<template>
    <v-form>
        <v-layout row wrap>
            <v-flex class="xs4">
                <v-text-field
                    label="Site"
                    type="text"
                    :value="item.bucket ? item.bucket.campaign.site.name : undefined"
                    color="blue-grey"
                    readonly
                />
            </v-flex>
            <v-flex class="xs4">
                <v-text-field
                    label="Year"
                    type="text"
                    :value="item.bucket ? item.bucket.campaign.year : undefined"
                    color="blue-grey"
                    readonly
                />
            </v-flex>
            <v-flex class="xs4">
                <v-text-field
                    label="Area"
                    type="text"
                    :value="item.bucket ? item.bucket.context.area.name : undefined"
                    color="blue-grey"
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
                    color="blue-grey"
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
                    class="text-strong"
                    readonly
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field
                    label="Field no"
                    type="text"
                    v-model="item.num"
                    :error-messages="fieldNumErrors"
                    @input="formMxValidate('vFieldNum')"
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
                <v-text-field
                    label="Field no"
                    type="text"
                    v-model="item.num"
                    :error-messages="fieldNumErrors"
                    @input="formMxValidate('vFieldNum')"
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
                    @blur="formMxValidate('vChronology')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-select
                    label="Class"
                    bottom
                    :items="vocabularies.p.class"
                    v-model="item.class"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocClass"
                    :loading="loadingVocClass"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vClass')"
                />
            </v-flex>
            <v-flex xs6>
                <v-select
                    label="Shape"
                    bottom
                    :items="vocabularies.p.shape"
                    v-model="item.shape"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocShape"
                    :loading="loadingVocShape"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vShape')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-select
                    label="Technique"
                    bottom
                    :items="vocabularies.p.technique"
                    v-model="item.technique"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocTechnique"
                    :loading="loadingVocTechnique"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vTechnique')"
                />
            </v-flex>
            <v-flex xs6>
                <v-select
                    label="Firing"
                    bottom
                    :items="vocabularies.p.firing"
                    v-model="item.firing"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocFiring"
                    :loading="loadingVocFiring"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vFiring')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-select
                    label="Inclusions (type)"
                    bottom
                    :items="vocabularies.p.inclusionsType"
                    v-model="item.inclusionsType"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocInclusionsType"
                    :loading="loadingVocInclusionsType"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vInclusionsType')"
                />
            </v-flex>
            <v-flex xs4>
                <v-select
                    label="Inclusions (size)"
                    bottom
                    :items="vocabularies.p.inclusionsSize"
                    v-model="item.inclusionsSize"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocInclusionsSize"
                    :loading="loadingVocInclusionsSize"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vInclusionsSize')"
                />
            </v-flex>
            <v-flex xs4>
                <v-select
                    label="Inclusions (freq)"
                    bottom
                    :items="vocabularies.p.inclusionsFrequency"
                    v-model="item.inclusionsFrequency"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocInclusionsFrequency"
                    :loading="loadingVocInclusionsFrequency"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vInclusionsFrequency')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-select
                    label="Inner Surface Treatment"
                    bottom
                    :items="vocabularies.p.innerSurfaceTreatment"
                    v-model="item.innerSurfaceTreatment"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocInnerSurfaceTreatment"
                    :loading="loadingVocInnerSurfaceTreatment"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vInnerSurfaceTreatment')"
                />
            </v-flex>
            <v-flex xs6>
                <v-select
                    label="Outer Surface Treatment"
                    bottom
                    :items="vocabularies.p.outerSurfaceTreatment"
                    v-model="item.outerSurfaceTreatment"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocOuterSurfaceTreatment"
                    :loading="loadingVocOuterSurfaceTreatment"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vOuterSurfaceTreatment')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-select
                    label="Inner Decoration"
                    bottom
                    :items="vocabularies.p.innerDecoration"
                    v-model="item.innerDecoration"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocInnerDecoration"
                    :loading="loadingVocInnerDecoration"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vInnerDecoration')"
                />
            </v-flex>
            <v-flex xs6>
                <v-select
                    label="Outer Decoration"
                    bottom
                    :items="vocabularies.p.outerDecoration"
                    v-model="item.outerDecoration"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocOuterDecoration"
                    :loading="loadingVocOuterDecoration"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vOuterDecoration')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-select
                    label="Inner Color"
                    bottom
                    :items="vocabularies.f.innerColor"
                    v-model="item.innerColor"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocInnerColor"
                    :loading="loadingVocInnerColor"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vInnerColor')"
                />
            </v-flex>
            <v-flex xs4>
                <v-select
                    label="Outer Color"
                    bottom
                    :items="vocabularies.f.outerColor"
                    v-model="item.outerColor"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocOuterColor"
                    :loading="loadingVocOuterColor"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vOuterColor')"
                />
            </v-flex>
            <v-flex xs4>
                <v-select
                    label="Core Color"
                    bottom
                    :items="vocabularies.f.coreColor"
                    v-model="item.coreColor"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocCoreColor"
                    :loading="loadingVocCoreColor"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vCoreColor')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-text-field
                    label="Drawing number"
                    type="text"
                    v-model="item.drawingNumber"
                    @input="formMxValidate('vDrawingNumber')"
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
                    type="text"
                    v-model="item.rimDiameter"
                    @input="formMxValidate('vRimDiameter')"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                    label="Rim Width"
                    type="text"
                    v-model="item.rimWidth"
                    @input="formMxValidate('vRimWidth')"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                    label="Wall Width"
                    type="text"
                    v-model="item.wallWidth"
                    @input="formMxValidate('vWallWidth')"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                    label="Max Wall Diameter"
                    type="text"
                    v-model="item.maxWallDiameter"
                    @input="formMxValidate('vMaxWallDiameter')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs3>
                <v-text-field
                    label="Base Width"
                    type="text"
                    v-model="item.baseWidth"
                    @input="formMxValidate('vBaseWidth')"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                    label="Base Height"
                    type="text"
                    v-model="item.baseHeight"
                    @input="formMxValidate('vBaseHeight')"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                    label="Base Diameter"
                    type="text"
                    v-model="item.baseDiameter"
                    @input="formMxValidate('vBaseDiameter')"
                />
            </v-flex>
            <v-flex align-start xs3>
                <v-text-field
                    label="General Height"
                    type="text"
                    v-model="item.height"
                    @input="formMxValidate('vGeneralHeight')"
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
                    @change="formMxValidate('vEnvanterlik')"
                />
            </v-flex>
            <v-flex xs4>
                <v-checkbox
                    label="Etutluk"
                    v-model="item.etutluk"
                    @change="formMxValidate('vEtutluk')"
                />
            </v-flex>
            <v-flex xs4>
                <v-checkbox
                    label="Restored"
                    v-model="item.restored"
                    @change="formMxValidate('vRestored')"
                />
            </v-flex>
        </v-layout>
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
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import {validationMixin} from 'vuelidate'
  import {required} from 'vuelidate/lib/validators'
  import {debounce} from '../util'

  export default {
    name: 'pottery-edit-data-form',
    extends: BaseDataForm,
    mixins: [
      validationMixin
    ],
    data() {
      return {
        buckets: [],
        searchBuckets: null,
        loadingBuckets: false,
        searchVocClass: null,
        loadingVocClass: false,
        searchVocChronology: null,
        loadingVocChronology: false,
        searchVocCoreColor: null,
        loadingVocCoreColor: false,
        searchVocFiring: null,
        loadingVocFiring: false,
        searchVocInclusionsType: null,
        loadingVocInclusionsType: false,
        searchVocInclusionsSize: null,
        loadingVocInclusionsSize: false,
        searchVocInclusionsFrequency: null,
        loadingVocInclusionsFrequency: false,
        searchVocInnerColor: null,
        loadingVocInnerColor: false,
        searchVocInnerDecoration: null,
        loadingVocInnerDecoration: false,
        searchVocInnerSurfaceTreatment: null,
        loadingVocInnerSurfaceTreatment: false,
        searchVocOuterColor: null,
        loadingVocOuterColor: false,
        searchVocOuterDecoration: null,
        loadingVocOuterDecoration: false,
        searchVocOuterSurfaceTreatment: null,
        loadingVocOuterSurfaceTreatment: false,
        searchVocShape: null,
        loadingVocShape: false,
        searchVocTechnique: null,
        loadingVocTechnique: false,
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
      vFieldNum() {
        return this.item.num
      },
      bucketErrors() {
        const errors = []
        if (!this.$v.bucket.$dirty) return errors
        !this.$v.bucket.required && errors.push('Bucket is required.')
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
      /**
       * Set the item.vocabularies arrays used by v-select vocabulary input
       * @param item
       * @param key
       * @param vocType
       * @param vocName
       */
      checkSelectVocabularies(item, key, vocType, vocName) {
        if (item[key] && !this.vocabularies[vocType][vocName]) {
          Vue.set(this.vocabularies[vocType], vocName, [item[key]])
        }
      },
      fetchVocabularyFirstEntries (event, type, name) {
        console.log(event)
      },
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
      bucket: {required},   //computed
      vFieldNum: {required},//computed
      vRegNum: {},          //computed
      vBaseDiameter: {},
      vBaseHeight: {},
      vBaseWidth: {},
      vChronology: {},
      vClass: {},
      vCoreColor: {},
      vEnvanterlik: {},
      vEtutluk: {},
      vFiring: {},
      vDrawingNumber: {},
      vGeneralHeight: {},
      vInclusionsType: {},
      vInclusionsSize: {},
      vInclusionsFrequency: {},
      vInnerColor: {},
      vInnerDecoration: {},
      vInnerSurfaceTreatment: {},
      vMaxWallDiameter: {},
      vOuterColor: {},
      vOuterDecoration: {},
      vOuterSurfaceTreatment: {},
      vRestored: {},
      vRimWidth: {},
      vRimDiameter: {},
      vShape: {},
      vTechnique: {},
      vWallWidth: {},
      remarks: {},
    },
    watch: {
      // select values MUST be set for showing text
      item(val) {
        if (val.bucket && !this.buckets.length) {
          this.buckets.push(this.addBucketCode(val.bucket))
        }
        const vocabularies = [
          ['chronology', 'f', 'chronology'],
          ['class', 'p', 'class'],
          ['firing', 'p', 'firing'],
          ['inclusionsType', 'p', 'inclusionsType'],
          ['inclusionsSize', 'p', 'inclusionsSize'],
          ['inclusionsFrequency', 'p', 'inclusionsFrequency'],
          ['innerSurfaceTreatment', 'p', 'innerSurfaceTreatment'],
          ['outerSurfaceTreatment', 'p', 'outerSurfaceTreatment'],
          ['innerDecoration', 'p', 'innerDecoration'],
          ['outerDecoration', 'p', 'outerDecoration'],
          ['outerColor', 'f', 'outerColor'],
          ['innerColor', 'f', 'innerColor'],
          ['coreColor', 'f', 'coreColor'],
          ['shape', 'p', 'shape'],
          ['technique', 'p', 'technique']
        ]
        for (const vocabulary of vocabularies) {
          this.checkSelectVocabularies(val, ...vocabulary)
        }
        if (!val.discr) {
          val.discr = 'P'
        }
      },
      searchBuckets(val) {
        val && this.fetchBuckets(val)
      },
      searchVocClass(val) {
        val && this.fetchVocabulary('p', 'class', val)
      },
      searchVocChronology(val) {
        this.fetchVocabulary('f', 'chronology', val)
      },
      searchVocFiring(val) {
        val && this.fetchVocabulary('p', 'firing', val)
      },
      searchVocInclusionsType(val) {
        val && this.fetchVocabulary('p', 'inclusionsType', val)
      },
      searchVocTechnique(val) {
        val && this.fetchVocabulary('p', 'technique', val)
      },
      searchVocInclusionsSize(val) {
        val && this.fetchVocabulary('p', 'inclusionsSize', val)
      },
      searchVocInclusionsFrequency(val) {
        val && this.fetchVocabulary('p', 'inclusionsFrequency', val)
      },
      searchVocInnerSurfaceTreatment(val) {
        val && this.fetchVocabulary('p', 'surfaceTreatment', val, 'innerSurfaceTreatment')
      },
      searchVocOuterSurfaceTreatment(val) {
        val && this.fetchVocabulary('p', 'surfaceTreatment', val, 'outerSurfaceTreatment')
      },
      searchVocInnerDecoration(val) {
        val && this.fetchVocabulary('p', 'decoration', val, 'innerDecoration')
      },
      searchVocCoreColor(val) {
        val && this.fetchVocabulary('f', 'color', val, 'coreColor')
      },
      searchVocInnerColor(val) {
        val && this.fetchVocabulary('f', 'color', val, 'innerColor')
      },
      searchVocOuterColor(val) {
        val && this.fetchVocabulary('f', 'color', val, 'outerColor')
      },
      searchVocShape(val) {
        val && this.fetchVocabulary('p', 'shape', val)
      },

    },
    mounted() {
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

<style scoped>
    .text-strong >>> input[type="text"] {
        font-weight: bold;
    }
</style>