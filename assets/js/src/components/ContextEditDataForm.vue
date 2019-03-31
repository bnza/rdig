<template>
    <v-form>
        <area-autocomplete-sub-form-layout
                :area.sync="item.area"
                :error-messages="validationErrors.area"
                />
        <v-layout row wrap>
            <v-flex xs3>
                <v-select
                        label="Type"
                        menu-props="bottom"
                        :items="$store.state.contextTypes"
                        v-model="item.type"
                        item-text="name"
                        item-value="id"
                        :error-messages="validationErrors.type"
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field
                        label="Num"
                        type="text"
                        v-model="item.num"
                        :error-messages="validationErrors.num"
                />
<!--                :readonly="!isEditable"
                :color="!isEditable ? 'grey lighten-1' : ''"-->
            </v-flex>
            <v-flex xs3>
                <v-text-field
                        label="Type of context"
                        type="number"
                        v-model="item.cType"
                        :error-messages="validationErrors.cType"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Chronology"
                        :term.sync="item.chronology"
                        :vocabulary="{type:'f', name: 'chronology'}"
                />
            </v-flex>
            <v-flex xs6>
                <phase-autocomplete
                        :item.sync="item.phase"
                        :site="area.site"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-textarea
                        outline
                        label="Description"
                        v-model="item.description"
                />
            </v-flex>
        </v-layout>
    </v-form>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import AreaAutocompleteSubFormLayout from './AreaAutocompleteSubFormLayout'
  import PhaseAutocomplete from './PhaseAutocomplete'
  import VocabularySubFormAutocomplete from './VocabularySubFormAutocomplete'
  import { validationMixin } from 'vuelidate'
  import { required, between } from 'vuelidate/lib/validators'
  import { requiredAutocompleteObject } from '../util'

  const typeErrors = ($v) => {
    const errors = []
    !$v.item.type.required && errors.push('Context type is required.')
    return errors
  }

  const numErrors = ($v) => {
    const errors = []
    !$v.item.num.required && errors.push('Context number is required.')
    return errors
  }

  const areaErrors = ($v) => {
    const errors = []
    !$v.item.area.requiredAutocompleteObject && errors.push('Area is required.')
    return errors
  }

  const cTypeErrors = ($v) => {
    const errors = []
    !$v.item.cType.between && errors.push('Type of context value must be comprised between 1 and 3')
    return errors
  }

  export default {
    name: 'context-edit-data-form',
    extends: BaseDataForm,
    components: {
      AreaAutocompleteSubFormLayout,
      PhaseAutocomplete,
      VocabularySubFormAutocomplete
    },
    mixins: [
      validationMixin
    ],
    validations: {
      item: {
        area: {requiredAutocompleteObject},
        num: {required},
        type: {required},
        cType: {between: between(1, 3)}
      }
    },
    computed: {
      area() {
        return this.item.area || {}
      },
      validationErrors () {
        return {
          area: areaErrors(this.$v),
          num: numErrors(this.$v),
          type: typeErrors(this.$v),
          cType: cTypeErrors(this.$v),
        }
      },
    }
  }
</script>
