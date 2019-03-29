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
                        :value="getFindingFieldCode(item)"
                        class="text-strong readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
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
                        :vocabulary="{type:'p', name: 'class'}"
                />
<!--                <v-autocomplete
                        label="Class"
                        menu-props="bottom"
                        :items="vocabularies.p.class"
                        v-model="item.class"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocClass"
                        :loading="loadingVocClass"
                        return-object
                        @blur="formMxValidate('vClass')"
                />-->
            </v-flex>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Shape"
                        :term.sync="item.shape"
                        :vocabulary="{type:'p', name: 'shape'}"
                />
<!--                <v-autocomplete
                        label="Shape"
                        menu-props="bottom"
                        :items="vocabularies.p.shape"
                        v-model="item.shape"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocShape"
                        :loading="loadingVocShape"
                        return-object
                        @blur="formMxValidate('vShape')"
                />-->
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Technique"
                        :term.sync="item.technique"
                        :vocabulary="{type:'p', name: 'technique'}"
                />
<!--                <v-autocomplete
                        label="Technique"
                        menu-props="bottom"
                        :items="vocabularies.p.technique"
                        v-model="item.technique"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocTechnique"
                        :loading="loadingVocTechnique"
                        return-object
                        autocomplete
                        @blur="formMxValidate('vTechnique')"
                />-->
            </v-flex>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Firing"
                        :term.sync="item.firing"
                        :vocabulary="{type:'p', name: 'firing'}"
                />
<!--                <v-autocomplete
                        label="Firing"
                        menu-props="bottom"
                        :items="vocabularies.p.firing"
                        v-model="item.firing"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocFiring"
                        :loading="loadingVocFiring"
                        return-object
                        @blur="formMxValidate('vFiring')"
                />-->
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Preservation State"
                        :term.sync="item.preservation"
                        :vocabulary="{type:'p', name: 'preservation'}"
                />
<!--                <v-autocomplete
                        label="Preservation State"
                        menu-props="bottom"
                        :items="vocabularies.p.preservation"
                        v-model="item.preservation"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocPreservation"
                        :loading="loadingVocPreservation"
                        return-object
                        autocomplete
                        @blur="formMxValidate('vPreservation')"
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
                        @blur="formMxValidate('vChronology')"
                />-->
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <vocabulary-sub-form-autocomplete
                        label="Chronology"
                        :term.sync="item.inclusionsType"
                        :vocabulary="{type:'p', name: 'inclusionsType'}"
                />
<!--                <v-autocomplete
                        label="Inclusions (type)"
                        menu-props="bottom"
                        :items="vocabularies.p.inclusionsType"
                        v-model="item.inclusionsType"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocInclusionsType"
                        :loading="loadingVocInclusionsType"
                        return-object
                        autocomplete
                        @blur="formMxValidate('vInclusionsType')"
                />-->
            </v-flex>
            <v-flex xs4>
                <vocabulary-sub-form-autocomplete
                        label="Inclusions (size)"
                        :term.sync="item.inclusionsSize"
                        :vocabulary="{type:'p', name: 'inclusionsSize'}"
                />
<!--                <v-autocomplete
                        label="Inclusions (size)"
                        menu-props="bottom"
                        :items="vocabularies.p.inclusionsSize"
                        v-model="item.inclusionsSize"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocInclusionsSize"
                        :loading="loadingVocInclusionsSize"
                        return-object
                        @blur="formMxValidate('vInclusionsSize')"
                />-->
            </v-flex>
            <v-flex xs4>
                <vocabulary-sub-form-autocomplete
                        label="Inclusions (freq)"
                        :term.sync="item.inclusionsFrequency"
                        :vocabulary="{type:'p', name: 'inclusionsFrequency'}"
                />
<!--                <v-autocomplete
                        label="Inclusions (freq)"
                        menu-props="bottom"
                        :items="vocabularies.p.inclusionsFrequency"
                        v-model="item.inclusionsFrequency"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocInclusionsFrequency"
                        :loading="loadingVocInclusionsFrequency"
                        return-object
                        autocomplete
                        @blur="formMxValidate('vInclusionsFrequency')"
                />-->
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Inner Surface Treatment"
                        :term.sync="item.innerSurfaceTreatment"
                        :vocabulary="{type:'p', name: 'innerSurfaceTreatment'}"
                />
<!--                <v-autocomplete
                        label="Inner Surface Treatment"
                        menu-props="bottom"
                        :items="vocabularies.p.innerSurfaceTreatment"
                        v-model="item.innerSurfaceTreatment"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocInnerSurfaceTreatment"
                        :loading="loadingVocInnerSurfaceTreatment"
                        return-object
                        @blur="formMxValidate('vInnerSurfaceTreatment')"
                />-->
            </v-flex>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Outer Surface Treatment"
                        :term.sync="item.outerSurfaceTreatment"
                        :vocabulary="{type:'p', name: 'outerSurfaceTreatment'}"
                />
<!--                <v-autocomplete
                        label="Outer Surface Treatment"
                        menu-props="bottom"
                        :items="vocabularies.p.outerSurfaceTreatment"
                        v-model="item.outerSurfaceTreatment"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocOuterSurfaceTreatment"
                        :loading="loadingVocOuterSurfaceTreatment"
                        return-object
                        autocomplete
                        @blur="formMxValidate('vOuterSurfaceTreatment')"
                />-->
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Inner Decoration"
                        :term.sync="item.innerDecoration"
                        :vocabulary="{type:'p', name: 'innerDecoration'}"
                />
<!--                <v-autocomplete
                        label="Inner Decoration"
                        menu-props="bottom"
                        :items="vocabularies.p.innerDecoration"
                        v-model="item.innerDecoration"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocInnerDecoration"
                        :loading="loadingVocInnerDecoration"
                        return-object
                        @blur="formMxValidate('vInnerDecoration')"
                />-->
            </v-flex>
            <v-flex xs6>
                <vocabulary-sub-form-autocomplete
                        label="Outer Decoration"
                        :term.sync="item.outerDecoration"
                        :vocabulary="{type:'p', name: 'outerDecoration'}"
                />
<!--                <v-autocomplete
                        label="Outer Decoration"
                        menu-props="bottom"
                        :items="vocabularies.p.outerDecoration"
                        v-model="item.outerDecoration"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocOuterDecoration"
                        :loading="loadingVocOuterDecoration"
                        return-object
                        autocomplete
                        @blur="formMxValidate('vOuterDecoration')"
                />-->
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <vocabulary-sub-form-autocomplete
                        label="Inner Color"
                        :term.sync="item.innerColor"
                        :vocabulary="{type:'f', name: 'color'}"
                />
<!--                <v-autocomplete
                        label="Inner Color"
                        menu-props="bottom"
                        :items="vocabularies.f.innerColor"
                        v-model="item.innerColor"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocInnerColor"
                        :loading="loadingVocInnerColor"
                        return-object
                        @blur="formMxValidate('vInnerColor')"
                />-->
            </v-flex>
            <v-flex xs4>
                <vocabulary-sub-form-autocomplete
                        label="Outer Color"
                        :term.sync="item.outerColor"
                        :vocabulary="{type:'f', name: 'color'}"
                />
<!--                <v-autocomplete
                        label="Outer Color"
                        menu-props="bottom"
                        :items="vocabularies.f.outerColor"
                        v-model="item.outerColor"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocOuterColor"
                        :loading="loadingVocOuterColor"
                        return-object
                        autocomplete
                        @blur="formMxValidate('vOuterColor')"
                />-->
            </v-flex>
            <v-flex xs4>
                <vocabulary-sub-form-autocomplete
                        label="Core Decoration"
                        :term.sync="item.coreColor"
                        :vocabulary="{type:'f', name: 'color'}"
                />
<!--                <v-autocomplete
                        label="Core Color"
                        menu-props="bottom"
                        :items="vocabularies.f.coreColor"
                        v-model="item.coreColor"
                        item-text="value"
                        item-value="id"
                        :search-input.sync="searchVocCoreColor"
                        :loading="loadingVocCoreColor"
                        return-object
                />-->
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-text-field
                        label="Drawing number"
                        type="text"
                        v-model="item.drawingNumber"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Measures</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs3>
                <v-text-field
                        label="Rim Diameter"
                        type="number"
                        min="0"
                        step="0.1"
                        v-model="item.rimDiameter"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                        type="number"
                        min="0"
                        step="0.1"
                        v-model="item.rimWidth"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                        label="Wall Width"
                        type="number"
                        min="0"
                        step="0.1"
                        v-model="item.wallWidth"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                        label="Max Wall Diameter"
                        type="number"
                        min="0"
                        step="0.1"
                        v-model="item.maxWallDiameter"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs3>
                <v-text-field
                        label="Base Width"
                        type="number"
                        v-model="item.baseWidth"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                        label="Base Height"
                        type="number"
                        min="0"
                        step="0.1"
                        v-model="item.baseHeight"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                        label="Base Diameter"
                        type="number"
                        min="0"
                        step="0.1"
                        v-model="item.baseDiameter"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                        label="General Height"
                        type="number"
                        min="0"
                        step="0.1s"
                        v-model="item.height"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Misc</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-checkbox
                        label="Envanterlik"
                        v-model="item.envanterlik"
                />
            </v-flex>
            <v-flex xs4>
                <v-checkbox
                        label="Etutluk"
                        v-model="item.etutluk"
                />
            </v-flex>
            <v-flex xs4>
                <v-checkbox
                        label="Restored"
                        v-model="item.restored"
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
    </v-form>
</template>

<script>
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

  const fieldNumErrors = ($v) => {
    const errors = []
    !$v.item.num.required && errors.push('Field number is required.')
    return errors
  }

  export default {
    name: 'pottery-edit-data-form',
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
          discr: 'P'
        },
      }
    },
    computed: {
      validationErrors () {
        return {
          bucket: bucketErrors(this.$v),
          num: fieldNumErrors(this.$v)
        }
      },
    },
    validations: {
      item: {
        bucket: {requiredAutocompleteObject},
        num: {required}
      },
    }
  }
</script>
