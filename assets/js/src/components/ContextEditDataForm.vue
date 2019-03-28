<template>
    <v-form>
        <v-autocomplete
            v-if="!parent__ && isEditable"
            label="Area"
            menu-props="bottom"
            :items="areas"
            v-model="areaId"
            item-text="name"
            item-value="id"
            hint="Site area, prepending site code (e.g. TH.A)"
            persistent-hint
            :error-messages="areaIdErrors"
            :search-input.sync="searchArea"
            @blur="formMxValidate('areaId')"
        />
        <v-layout v-else-if="item.area" row wrap>
            <v-flex xs6>
                <v-text-field
                    label="Site"
                    type="text"
                    v-model="area.site.code"
                    class="readonly-field"
                    color="grey lighten-1"
                    readonly
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field
                    label="Area"
                    type="text"
                    v-model="item.area.code"
                    class="readonly-field"
                    color="grey lighten-1"
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
            <v-flex xs6>
                <v-text-field
                    label="Num"
                    type="text"
                    v-model="num"
                    :readonly="!isEditable"
                    :color="!isEditable ? 'grey lighten-1' : ''"
                />
            </v-flex>
            <v-flex xs3>
                <v-text-field
                    label="Type of context"
                    type="number"
                    v-model="item.cType"
                    :error-messages="cTypeErrors"
                    @input="formMxValidate('cType')"
                    @blur="formMxValidate('cType')"
                />
            </v-flex>
            <v-flex xs12>
                <v-select
                    label="Chronology"
                    bottom
                    :items="vocabularies.f.chronology"
                    v-model="vocabularyChronology"
                    item-text="value"
                    :search-input.sync="searchVocChronology"
                    @blur="formMxValidate('chronology')"
                    autocomplete
                    return-object
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-textarea
                        outline
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
  import {required, between} from 'vuelidate/lib/validators'
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
      description: {},
      cType: {between: between(1, 3)}
    },
    computed: {
      isEditable () {
        return !this.item.id || this.$store.getters['account/isAdmin']
      },
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
          if (value.id === '') {
            value = null
          }
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
      },
      cTypeErrors() {
        const errors = []
        //if (!this.$v.cType.$dirty) return errors
        !this.$v.cType.between && errors.push('Type of context value must be comprised between 1 and 3')
        return errors
      },
    },
    watch: {
      // select values MUST be set for showing text
      item (val) {
        if (val.chronology && !this.vocabularies.f.chronology) {
          Vue.set(this.vocabularies.f, 'chronology', [val.chronology])
        }
        if (val.area && !this.areas.length) {
          const area = {
            id: val.area.id,
            name: `${val.area.site.code}.${val.area.code}`
          }
          Vue.set(this, 'areas', [area])
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
