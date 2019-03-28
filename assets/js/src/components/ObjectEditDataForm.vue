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
                        :value="item.bucket && item.bucket.campaign ? getFindingRegCode(item) : undefined"
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
                        type="number"
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
                        label="Class"
                        :term.sync="item.class"
                        :vocabulary="{type:'o', name: 'class'}"
                        :error-messages="validationErrors.class"
                        :required="true"
                        hint="This field is required"
                />
            </v-flex>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Type"
                        :term.sync="item.type"
                        :vocabulary="{type:'o', name: 'type'}"
                        :error-messages="validationErrors.type"
                        :required="true"
                        hint="This field is required"
                />
            </v-flex>
            <v-flex xs12>
                <v-text-field
                        label="Sub Type"
                        type="text"
                        v-model="item.subType"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Material Class"
                        :term.sync="item.materialClass"
                        :vocabulary="{type:'o', name: 'materialClass'}"
                />
            </v-flex>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Material Type"
                        :term.sync="item.materialType"
                        :vocabulary="{type:'o', name: 'materialType'}"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Technique"
                        :term.sync="item.technique"
                        :vocabulary="{type:'o', name: 'technique'}"
                />
            </v-flex>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Technique"
                        :term.sync="item.decoration"
                        :vocabulary="{type:'o', name: 'decoration'}"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Preservation state"
                        :term.sync="item.preservation"
                        :vocabulary="{type:'o', name: 'preservation'}"
                />
            </v-flex>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Munsell color"
                        :term.sync="item.color"
                        :vocabulary="{type:'f', name: 'color'}"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12>
                <vocabulary-sub-form-autocomplete
                        label="Chronology"
                        :term.sync="item.chronology"
                        :vocabulary="{type:'f', name: 'chronology'}"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-text-field
                        label="Date of retrieval"
                        type="date"
                        v-model="retrievalDate"
                        @input="formMxValidate('vRetrievalDate')"
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field
                        label="Fragments"
                        type="number"
                        v-model="item.fragments"
                        @input="formMxValidate('vFragments')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Coordinates</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs4>
                <v-text-field
                        type="number"
                        label="North"
                        v-model="item.coordN"
                />
            </v-flex>
            <v-flex align-start xs4>
                <v-text-field
                        type="number"
                        label="East"
                        v-model="item.coordE"
                />
            </v-flex>
            <v-flex align-start xs4>
                <v-text-field
                        type="number"
                        label="Elevation"
                        v-model="item.coordZ"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Measures</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs4>
                <v-text-field
                        type="number"
                        min="0"
                        step="0.1"
                        label="Height"
                        v-model="item.height"
                />
            </v-flex>
            <v-flex align-start xs4>
                <v-text-field
                        type="number"
                        min="0"
                        step="0.1"
                        label="Length"
                        v-model="item.length"
                />
            </v-flex>
            <v-flex align-start xs4>
                <v-text-field
                        type="number"
                        min="0"
                        step="0.1"
                        label="Width"
                        v-model="item.width"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs6>
                <v-text-field
                        type="number"
                        min="0"
                        step="0.1"
                        label="Thickness"
                        v-model="item.thickness"
                />
            </v-flex>
            <v-flex align-start xs6>
                <v-text-field
                        type="number"
                        min="0"
                        step="0.1"
                        label="Weight"
                        v-model="item.weight"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs6>
                <v-text-field
                        type="number"
                        min="0"
                        step="0.1"
                        label="Diameter"
                        v-model="item.diameter"
                />
            </v-flex>
            <v-flex align-start xs6>
                <v-text-field
                        type="number"
                        min="0"
                        step="0.1"
                        label="Perforation Diameter"
                        v-model="item.perforationDiameter"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Misc</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-checkbox
                        label="Photo"
                        v-model="item.photo"

                />
            </v-flex>
            <v-flex xs6>
                <v-checkbox
                        label="Drawing"
                        v-model="item.drawing"
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
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-textarea
                        outline
                        label="Inscription"
                        v-model="item.inscription"

                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-textarea
                        outline
                        label="Remarks"
                        v-model="item.remarks"

                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Conservation</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field
                        type="number"
                        label="Year of conservation"
                        v-model="item.conservationYear"

                />
            </v-flex>
            <v-flex align-start xs9>
                <v-text-field
                        type="text"
                        label="Location"
                        v-model="item.location"

                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-checkbox
                        label="Envanterlik"
                        v-model="item.envanterlik"

                />
            </v-flex>
            <v-flex xs6>
                <v-checkbox
                        label="Etutluk"
                        v-model="item.etutluk"

                />
            </v-flex>
        </v-layout>
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import BucketAutocompleteSubFormLayout from './BucketAutocompleteSubFormLayout'
  import VocabularySubFormAutocomplete from './VocabularySubFormAutocomplete'
  import { validationMixin } from 'vuelidate'
  import { required } from 'vuelidate/lib/validators'
  import { requiredAutocompleteObject } from '../util'

  const bucketErrors = ($v) => {
    const errors = []
    !$v.item.bucket.requiredAutocompleteObject && errors.push('Bucket is required.')
    return errors
  }

  const classErrors = ($v) => {
    const errors = []
    !$v.item.class.requiredAutocompleteObject && errors.push('Object class is required.')
    return errors
  }

  const typeErrors = ($v) => {
    const errors = []
    !$v.item.type.requiredAutocompleteObject && errors.push('Object type is required.')
    return errors
  }

  const fieldNumErrors = ($v) => {
    const errors = []
    !$v.item.num.required && errors.push('Field number is required.')
    return errors
  }

  export default {
    name: 'object-edit-data-form',
    extends: BaseDataForm,
    mixins: [
      validationMixin
    ],
    components: {
      BucketAutocompleteSubFormLayout,
      VocabularySubFormAutocomplete
    },
    computed: {
      retrievalDate: {
        get () {
          let date = this.item.retrievalDate
          if (date && date.hasOwnProperty('date')) {
            date = date.date.substr(0, 10)
          }
          return date
        },
        set (value) {
          Vue.set(this.item, 'retrievalDate', value)
        }
      },
      validationErrors() {
        return {
          bucket: bucketErrors(this.$v),
          class: classErrors(this.$v),
          type: typeErrors(this.$v),
          num: fieldNumErrors(this.$v)
        }
      },
    },
    validations: {
      item: {
        bucket: {requiredAutocompleteObject},
        class: {requiredAutocompleteObject},
        type: {requiredAutocompleteObject},
        num: {required}
      },
    },
/*    watch: {
      formMxIsInvalid(flag) {
        this.uuidMxSet('isInvalid', flag, this.$_FormMx_uuid)
      }
    }*/
  }
</script>
