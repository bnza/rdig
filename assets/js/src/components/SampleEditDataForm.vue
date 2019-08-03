<template>
    <v-form>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Provenance</v-subheader>
            </v-flex>
        </v-layout>
        <bucket-autocomplete-sub-form-layout
                :bucket.sync="item.bucket"
                :error-messages="validationErrors.bucket"
        />
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Identification</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-text-field
                        label="Field code"
                        type="text"
                        :value="getFindingFieldCode(item)"
                        class="text-strong readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field
                        label="Registration code"
                        type="text"
                        class="text-strong readonly-field"
                        :value="getFindingRegCode(item)"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-text-field
                    label="Field no"
                    type="text"
                    v-model="item.num"
                    :error-messages="validationErrors.num"
                    persistent-hint
                    hint="This field is required"
                    required
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field
                    label="Reg no"
                    type="text"
                    v-model="item.no"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Classification</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Type"
                        :term.sync="item.type"
                        :vocabulary="{type:'s', name: 'type'}"
                        :required="true"
                        :error-messages="validationErrors.type"
                        hint="This field is required"
                />
<!--                <v-autocomplete
                    label="Type"
                    menu-props="bottom"
                    :items="vocabularies.s.type"
                    v-model="item.type"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocType"
                    :loading="loadingVocType"
                    return-object
                    :error-messages="typeErrors"
                    @blur="formMxValidate('vType')"
                    persistent-hint
                    hint="This field is required"
                    required
                />-->
            </v-flex>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Chronology"
                        :term.sync="item.chronology"
                        :vocabulary="{type:'f', name: 'chronology'}"
                />
<!--                <v-autocomplete
                    label="Chronology"
                    menu-props="bottom"
                    :items="vocabularies.f.chronology"
                    v-model="item.chronology"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocChronology"
                    :loading="loadingVocChronology"
                    return-object
                    @blur="formMxValidate('chronology')"
                />-->
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12>
                <v-text-field
                    label="Status"
                    type="text"
                    v-model="item.status"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-layout row wrap>
                <v-flex align-start xs12>
                    <v-textarea
                        outline
                        label="Remarks"
                        v-model="item.remarks"
                    />
                </v-flex>
            </v-layout>
        </v-layout>
    </v-form>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import BucketAutocompleteSubFormLayout from './BucketAutocompleteSubFormLayout'
  import VocabularySubFormAutocomplete from './VocabularySubFormAutocomplete'
  import {validationMixin} from 'vuelidate'
  import {required} from 'vuelidate/lib/validators'
  import { requiredAutocompleteObject } from '../util'

  const bucketErrors = ($v) => {
    const errors = []
    !$v.item.bucket.requiredAutocompleteObject && errors.push('Bucket is required.')
    return errors
  }

  const typeErrors = ($v) => {
    const errors = []
    !$v.item.type.requiredAutocompleteObject && errors.push('Sample type is required.')
    return errors
  }

  const fieldNumErrors = ($v) => {
    const errors = []
    !$v.item.num.required && errors.push('Field number is required.')
    return errors
  }

  export default {
    name: 'sample-edit-data-form',
    extends: BaseDataForm,
    components: {
      BucketAutocompleteSubFormLayout,
      VocabularySubFormAutocomplete
    },
    mixins: [
      validationMixin
    ],
    data() {
      return {
        item_: {
          discr: 'S'
        },
      }
    },
    computed: {
      validationErrors () {
        return {
          bucket: bucketErrors(this.$v),
          type: typeErrors(this.$v),
          num: fieldNumErrors(this.$v)
        }
      },
    },
    validations: {
      item: {
        bucket: {requiredAutocompleteObject},
        type: {requiredAutocompleteObject},
        num: {required}
      },
    },
    methods: {
      fetchBucket(bucketId) {
        const vm = this
        const config = {
          method: 'get',
          url: `/data/bucket/${bucketId}`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            vm.$set(vm.item, 'bucket', response.data)
          }
        )
      }
    },
    mounted () {
      if (this.parent__) {
        this.fetchBucket(this.parent__.id)
      }
    }
  }
</script>
