<template>
    <v-form>
        <v-select
            v-if="!parent__ && !item.id"
            label="Area"
            bottom
            :items="areas"
            v-model="areaId"
            item-text="name"
            item-value="id"
            :error-messages="areaIdErrors"
            :search-input.sync="searchArea"
            @blur="formMxValidate('areaId')"
            autocomplete
        />
        <v-layout v-else-if="item.area" row wrap>
            <v-flex xs6>
                <v-text-field
                    label="Site"
                    type="text"
                    v-model="area.site.code"
                    readonly
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field
                    label="Area"
                    type="text"
                    v-model="item.area.code"
                    readonly
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-select
                    label="Type"
                    bottom
                    :items="$store.state.contextTypes"
                    v-model="type"
                    item-text="name"
                    item-value="id"
                    :error-messages="typeErrors"
                    @input="formMxValidate('type')"
                    @blur="formMxValidate('type')"
                />
            </v-flex>
            <v-flex xs9>
                <v-text-field
                    label="Num"
                    type="text"
                    v-model="num"
                    readonly
                />
            </v-flex>
            <v-flex xs12>
                <v-select
                    label="Chronology"
                    bottom
                    :items="vocabularies.f.chronology"
                    v-model="vocabularyChronology"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocChronology"
                    @blur="formMxValidate('chronology')"
                    autocomplete
                    return-object
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-text-field
                    textarea
                    label="Description"
                    v-model="item.description"
                    @blur="formMxValidate('description')"/>
            </v-flex>
        </v-layout>
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import AreaReadFieldsItem from './AreaReadFieldsItem'
  import {validationMixin} from 'vuelidate'
  import {required, maxLength} from 'vuelidate/lib/validators'
  import {debounce} from '../util'

  export default {
    name: 'context-edit-data-form',
    extends: BaseDataForm,
    components: {
      AreaReadFieldsItem
    },
    mixins: [
      validationMixin
    ],
    data() {
      return {
        areas: [],
        searchArea: null,
        searchVocChronology: null,
        loading: false
      }
    },
    validations: {
      areaId: {required},
      type: {required},
      chronology: {},
      description: {}
    },
    computed: {
      area: {
        get() {
          return this.item.area || {site: {}}
        },
        set(value) {
          Vue.set(this.item, 'area', value)
        }
      },
      areaId: {
        get() {
          return this.item.area ? this.item.area.id : undefined
        },
        set(value) {
          if (!this.item.area) {
            Vue.set(this.item, 'area', {})
          }
          Vue.set(this.item.area, 'id', value)
        }
      },
      vocabularyChronology: {
        get() {
          return this.item.chronology ? this.item.chronology : {}
        },
        set(value) {
          Vue.set(this.item, 'chronology', value)
        }
      },
      type: {
        get() {
          return this.item.type
        },
        set(value) {
          Vue.set(this.item_, 'type', value.toUpperCase())
        }
      },
      num: {
        get() {
          return this.item.num
        },
        set(value) {
          Vue.set(this.item, 'num', value)
        }
      },
      typeErrors() {
        const errors = []
        if (!this.$v.type.$dirty) return errors
        !this.$v.type.required && errors.push('Context type is required.')
        return errors
      },
      areaIdErrors() {
        const errors = []
        if (!this.$v.areaId.$dirty) return errors
        !this.$v.areaId.required && errors.push('Area is required.')
        return errors
      }
    },
    watch: {
      // select values MUST be set for showing text
      item (val) {
        if (val.chronology && !this.vocabularies.f.chronology) {
          Vue.set(this.vocabularies.f, 'chronology', [this.item.chronology])
        }
      },
      searchArea (val) {
        val && this.fetchAreas(val)
      },
      searchVocChronology (val) {
        val && this.fetchVocabulary('f', 'chronology', val)
      }
    },
    methods: {
      fetchAreas: debounce(function (pattern) {
        this.loading = true
        if (typeof pattern === 'string') {
          const config = {
            method: 'get',
            url: `data/area?re=${pattern}`
          }
          this.$store.dispatch('requests/perform', config).then(
            (response) => {
              this.loading = false
              this.areas = response.data
            }
          ).catch(
            (error) => {
              this.loading = false
            }
          )
        }
      }, 250),
      fetchArea () {
        const config = {
          method: 'get',
          url: `data/area/${this.parent__.id}`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            Vue.set(this.item, 'area', response.data)
          }
        ).catch(
          (error) => {
            this.loading = false
          }
        )
      }
    },
    mounted() {
      if (!this.areaId && this.parent__) {
        this.fetchArea()
      }
    }
  }
</script>