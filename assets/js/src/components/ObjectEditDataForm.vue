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
                    label="Registration code"
                    type="text"
                    :value="getFindingRegCode(item)"
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
            <v-flex align-start xs12>
                <v-subheader>Classification</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-select
                    label="Class"
                    bottom
                    :items="vocabularies.o.class"
                    v-model="item.class"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocClass"
                    :loading="loadingVocClass"
                    return-object
                    autocomplete
                    :error-messages="classErrors"
                    @blur="formMxValidate('vClass')"
                />
            </v-flex>
            <v-flex xs6>
                <v-select
                    label="Type"
                    bottom
                    :items="vocabularies.o.type"
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
            <v-flex xs12>
                <v-text-field
                    label="Sub Type"
                    type="text"
                    v-model="item.subType"
                    @input="formMxValidate('vSubType')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-select
                    label="Material Class"
                    bottom
                    :items="vocabularies.o.materialClass"
                    v-model="item.materialClass"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocMaterialClass"
                    :loading="loadingVocMaterialClass"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vMaterialClass')"
                />
            </v-flex>
            <v-flex xs6>
                <v-select
                    label="Material Type"
                    bottom
                    :items="vocabularies.o.materialType"
                    v-model="item.materialType"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocMaterialType"
                    :loading="loadingVocMaterialType"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vMaterialType')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-select
                    label="Technique"
                    bottom
                    :items="vocabularies.o.technique"
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
                    label="Decoration"
                    bottom
                    :items="vocabularies.o.decoration"
                    v-model="item.decoration"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocDecoration"
                    :loading="loadingVocDecoration"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vDecoration')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-select
                    label="Preservation state"
                    bottom
                    :items="vocabularies.o.preservation"
                    v-model="item.preservation"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocPreservation"
                    :loading="loadingVocPreservation"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vPreservation')"
                />
            </v-flex>
            <v-flex xs6>
                <v-select
                    label="Munsell color"
                    bottom
                    :items="vocabularies.f.color"
                    v-model="item.color"
                    item-text="value"
                    item-value="id"
                    :search-input.sync="searchVocColor"
                    :loading="loadingVocColor"
                    return-object
                    autocomplete
                    @blur="formMxValidate('vColor')"
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
                    @input="formMxValidate('vCoordN')"
                />
            </v-flex>
            <v-flex align-start xs4>
                <v-text-field
                    type="number"
                    label="East"
                    v-model="item.coordE"
                    @input="formMxValidate('vCoordE')"
                />
            </v-flex>
            <v-flex align-start xs4>
                <v-text-field
                    type="number"
                    label="Elevation"
                    v-model="item.coordZ"
                    @input="formMxValidate('vElevation')"
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
                    label="Height"
                    v-model="item.height"
                    @input="formMxValidate('vHeight')"
                />
            </v-flex>
            <v-flex align-start xs4>
                <v-text-field
                    type="number"
                    label="Length"
                    v-model="item.length"
                    @input="formMxValidate('vLength')"
                />
            </v-flex>
            <v-flex align-start xs4>
                <v-text-field
                    type="number"
                    label="Width"
                    v-model="item.width"
                    @input="formMxValidate('vWidth')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs6>
                <v-text-field
                    type="number"
                    label="Thickness"
                    v-model="item.thickness"
                    @input="formMxValidate('vThickness')"
                />
            </v-flex>
            <v-flex align-start xs6>
                <v-text-field
                    type="number"
                    label="Weight"
                    v-model="item.weight"
                    @input="formMxValidate('vWeight')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs6>
                <v-text-field
                    type="number"
                    label="Diameter"
                    v-model="item.diameter"
                    @input="formMxValidate('vDiameter')"
                />
            </v-flex>
            <v-flex align-start xs6>
                <v-text-field
                    type="number"
                    label="Perforation Diameter"
                    v-model="item.perforationDiameter"
                    @input="formMxValidate('vPerforationDiameter')"
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
                    @change="formMxValidate('vPhoto')"
                />
            </v-flex>
            <v-flex xs6>
                <v-checkbox
                    label="Drawing"
                    v-model="item.drawing"
                    @change="formMxValidate('vDrawing')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-text-field
                    textarea
                    label="Description"
                    v-model="item.description"
                    @input="formMxValidate('vDescription')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-text-field
                    textarea
                    label="Inscription"
                    v-model="item.inscription"
                    @input="formMxValidate('vInscription')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-text-field
                    textarea
                    label="Remarks"
                    v-model="item.remarks"
                    @input="formMxValidate('vRemarks')"
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
                    type="text"
                    label="Year of conservation"
                    v-model="item.conservationYear"
                    @input="formMxValidate('vConservationYear')"
                />
            </v-flex>
            <v-flex align-start xs9>
                <v-text-field
                    type="text"
                    label="Location"
                    v-model="item.location"
                    @input="formMxValidate('vLocation')"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-checkbox
                    label="Envanterlik"
                    v-model="item.envanterlik"
                    @change="formMxValidate('vEnvanterlik')"
                />
            </v-flex>
            <v-flex xs6>
                <v-checkbox
                    label="Etutluk"
                    v-model="item.etutluk"
                    @change="formMxValidate('vEtutluk')"
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
    name: 'object-edit-data-form',
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
        searchVocColor: null,
        loadingVocColor: false,
        searchVocDecoration: null,
        loadingVocDecoration: false,
        searchVocMaterialClass: null,
        loadingVocMaterialClass: false,
        searchVocMaterialType: null,
        loadingVocMaterialType: false,
        searchVocPreservation: null,
        loadingVocPreservation: false,
        searchVocTechnique: null,
        loadingVocTechnique: false,
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
      retrievalDate: {
        get() {
            let date = this.item.retrievalDate
            if (date && date.hasOwnProperty('date')) {
              date = date.date.substr(0, 10);
            }
            return date
        },
        set(value) {
          Vue.set(this.item, 'retrievalDate', value)
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
      classErrors() {
        const errors = []
        if (!this.$v.vClass.$dirty) return errors
        !this.$v.vClass.required && errors.push('Object class is required.')
        return errors
      },
      typeErrors() {
        const errors = []
        if (!this.$v.vType.$dirty) return errors
        !this.$v.vType.required && errors.push('Object type is required.')
        return errors
      },
      fieldNumErrors() {
        const errors = []
        if (!this.$v.vFieldNum.$dirty) return errors
        !this.$v.vFieldNum.required && errors.push('Field number is required.')
        return errors
      },
    },
    methods: {
      addBucketCode(bucket) {
        let year = bucket.campaign.year.toString().substr(2)
        bucket.code = `${bucket.campaign.site.code}${year}P${bucket.num}`
        return bucket
      },
      /**
       * Set the item.vocabularies arrays used by v-select vocabulary input
       * @param item
       * @param key
       * @param vocType
       * @param vocName
       * @TODO merge with PotteryEditDataForm method
       */
      checkSelectVocabularies(item, key, vocType, vocName) {
        if (item[key] && !this.vocabularies[vocType][vocName]) {
          Vue.set(this.vocabularies[vocType], vocName, [item[key]])
        }
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
      vChronology: {},
      vClass: {},
      vColor: {},
      vConservationYear: {},
      vCoordE: {},
      vCoordN: {},
      vDecoration: {},
      vDescription: {},
      vDiameter: {},
      vDrawing: {},
      vEnvanterlik: {},
      vElevation: {},
      vEtutluk: {},
      vFieldNum: {required},
      vFragments: {},
      vHeight: {},
      vInscription: {},
      vLength: {},
      vLocation: {},
      vMaterialClass: {},
      vMaterialType: {},
      vPerforationDiameter: {},
      vPhoto: {},
      vPreservation: {},
      vRegNum: {},
      vRemarks: {},
      vRetrievalDate: {},
      vSubType: {},
      vTechnique: {},
      vThickness: {},
      vType: {},
      vWeight: {},
      vWidth: {},
    },
    watch: {
      // select values MUST be set for showing text
      item(val) {
        if (val.bucket && !this.buckets.length) {
          this.buckets.push(this.addBucketCode(val.bucket))
        }
        const vocabularies = [
          ['chronology', 'f', 'chronology'],
          ['class', 'o', 'class'],
          ['type', 'o', 'type'],
          ['materialClass', 'o', 'materialClass'],
          ['materialType', 'o', 'materialType'],
          ['technique', 'o', 'technique'],
          ['decoration', 'o', 'decoration'],
          ['preservation', 'o', 'preservation'],
          ['color', 'f', 'color'],
        ]
        for (const vocabulary of vocabularies) {
          this.checkSelectVocabularies(val, ...vocabulary)
        }
        if (!val.discr) {
          val.discr = 'O'
        }
      },
      searchBuckets(val) {
        val && this.fetchBuckets(val)
      },
      searchVocClass(val) {
        val && this.fetchVocabulary('o', 'class', val)
      },
      searchVocDecoration(val) {
        val && this.fetchVocabulary('o', 'decoration', val)
      },
      searchVocMaterialClass(val) {
        val && this.fetchVocabulary('o', 'materialClass', val)
      },
      searchVocMaterialType(val) {
        val && this.fetchVocabulary('o', 'materialType', val)
      },
      searchVocTechnique(val) {
        val && this.fetchVocabulary('o', 'technique', val)
      },
      searchVocType(val) {
        val && this.fetchVocabulary('o', 'type', val)
      },
      searchVocChronology(val) {
        val && this.fetchVocabulary('f', 'chronology', val)
      },
      searchVocPreservation(val) {
        val && this.fetchVocabulary('o', 'preservation', val)
      },
      searchVocColor(val) {
        val && this.fetchVocabulary('f', 'color', val)
      }
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