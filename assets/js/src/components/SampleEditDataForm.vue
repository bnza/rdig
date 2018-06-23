<template>
    <v-form>
        <v-layout row wrap>
            <v-flex class="xs4">
                <v-text-field
                    label="Site"
                    type="text"
                    :value="item.bucket ? item.bucket.campaign.site.name : undefined"
                    readonly
                />
            </v-flex>
            <v-flex class="xs4">
                <v-text-field
                    label="Year"
                    type="text"
                    :value="item.bucket ? item.bucket.campaign.year : undefined"
                    readonly
                />
            </v-flex>
            <v-flex class="xs4">
                <v-text-field
                    label="Area"
                    type="text"
                    :value="item.bucket ? item.bucket.context.area.name : undefined"
                    readonly
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex class="xs6">
                <v-text-field
                    label="Context"
                    type="text"
                    :value="item.bucket ? `${item.bucket.context.type}.${item.bucket.context.num}` : undefined"
                    readonly
                />
            </v-flex>
            <v-flex class="xs6">
                <v-select
                    label="Bucket"
                    bottom
                    :items="buckets"
                    v-model="item.bucket"
                    item-text="code"
                    item-value="id"
                    :search-input.sync="searchBuckets"
                    :loading="loadingBuckets"
                    return-object
                    autocomplete
                    mask="AA.##.P.###n"
                    :error-messages="bucketErrors"
                    @blur="formMxValidate('bucket')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-text-field
                    label="Field no"
                    type="text"
                    v-model="item.num"
                    :error-messages="fieldNumErrors"
                    @input="formMxValidate('vFieldNum')"
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field
                    label="Reg no"
                    type="text"
                    v-model="item.no"
                    @input="formMxValidate('vRegNum')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-select
                    label="Type"
                    bottom
                    :items="vocabularies.s.type"
                    v-model="item.type"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocType"
                    :loading="loadingVocType"
                    return-object
                    autocomplete
                    :error-messages="typeErrors"
                    @blur="formMxValidate('vType')"
                />
            </v-flex>
            <v-flex xs6>
                <v-select
                    label="Chronology"
                    bottom
                    :items="vocabularies.f.chronology"
                    v-model="item.chronology"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocChronology"
                    :loading="loadingVocChronology"
                    return-object
                    autocomplete
                    @blur="formMxValidate('chronology')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12>
                <v-text-field
                    label="Status"
                    type="text"
                    v-model="item.status"
                    @input="formMxValidate('status')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-layout row wrap>
                <v-flex align-start xs12>
                    <v-text-field
                        textarea
                        label="Remarks"
                        v-model="item.remarks"
                        @input="formMxValidate('remarks')"
                    />
                </v-flex>
            </v-layout>
        </v-layout>
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import {validationMixin} from 'vuelidate'
  import {required} from 'vuelidate/lib/validators'
  import {debounce} from '../util'

  export default {
    name: 'sample-edit-data-form',
    extends: BaseDataForm,
    mixins: [
      validationMixin
    ],
    data() {
      return {
        buckets: [],
        searchBuckets: null,
        loadingBuckets: false,
        searchVocType: null,
        loadingVocType: false,
        searchVocChronology: null,
        loadingVocChronology: false,
      }
    },
    computed: {
      bucket: {
        get() {
          if (this.item.bucket) {
            return this.addBucketCode(this.item.bucket)
          }
          return {}
        },
        set(value) {
          Vue.set(this.item, 'bucket', value)
        }
      },
      vType() {
        return this.item.type ? this.item.type.id : undefined
      },
      vFieldNum() {
        return this.item.num
      },
      bucketErrors() {
        const errors = []
        if (!this.$v.bucket.$dirty) return errors
        !this.$v.bucket.required && errors.push('Bucket is required.')
        return errors
      },
      typeErrors() {
        const errors = []
        if (!this.$v.vType.$dirty) return errors
        !this.$v.vType.required && errors.push('Sample type is required.')
        return errors
      },
      fieldNumErrors() {
        const errors = []
        if (!this.$v.vFieldNum.$dirty) return errors
        !this.$v.vFieldNum.required && errors.push('Field no is required.')
        return errors
      },
    },
    methods: {
      addBucketCode(bucket) {
        let year = bucket.campaign.year.toString().substr(2)
        bucket.code = `${bucket.campaign.site.code}${year}P${bucket.num}`
        return bucket
      },
      fetchBuckets: debounce(function (pattern) {
        this.loading = true
        if (typeof pattern === 'string') {
          const config = {
            method: 'get',
            url: `data/bucket/re/${pattern}`
          }
          this.$store.dispatch('requests/perform', config).then(
            (response) => {
              this.loading = false
              this.buckets = response.data
            }
          ).catch(
            (error) => {
              this.loading = false
            }
          )
        }
      }, 250),
    },
    validations: {
      bucket: {required},
      vType: {required},
      vFieldNum: {required},
      vRegNum: {},
      chronology: {},
      status: {},
      remarks: {},
    },
    watch: {
      // select values MUST be set for showing text
      item(val) {
        if (val.bucket && !this.buckets.length) {
          this.buckets.push(this.addBucketCode(val.bucket))
        }
        if (val.type && !this.vocabularies.s.type) {
          Vue.set(this.vocabularies.s, 'type', [val.type])
        }
        if (val.chronology && !this.vocabularies.f.chronology) {
          Vue.set(this.vocabularies.f, 'chronology', [val.chronology])
        }
        if (!val.discr) {
          val.discr = 'S'
        }
      },
      searchBuckets(val) {
        val && this.fetchBuckets(val)
      },
      searchVocType(val) {
        val && this.fetchVocabulary('s', 'type', val)
      },
      searchVocChronology(val) {
        val && this.fetchVocabulary('f', 'chronology', val)
      }
    },
    mounted () {
      if (!this.item.bucket && this.parent__ && this.parent__.table === 'bucket') {
        this.loadingBuckets = true
        const config = {
          method: 'get',
          url: `data/bucket/${this.parent__.id}`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.loadingBuckets = false
            Vue.set(this.item, 'bucket', response.data)
          }
        ).catch(
          (error) => {
            this.loadingBuckets = false
          }
        )
      }
    }
  }
</script>