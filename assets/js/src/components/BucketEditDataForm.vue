<template>
    <v-form>
        <context-autocomplete-sub-form-layout
                :context.sync="item.context"
                :error-messages="validationErrors.context"
        />
        <v-layout row wrap>
            <v-flex xs6>
                <campaign-autocomplete
                        :site="site"
                        :campaign.sync="item.campaign"
                        :error-messages="validationErrors.campaign"
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field
                        label="Number"
                        type="text"
                        v-model="item.num"
                        :error-messages="validationErrors.num"
                        required
                />
                <!--                :readonly="isReadOnly"
                                :hint="isReadOnly ? 'Only superuser can change bucket number' : ''"
                                :color="isReadOnly ? 'grey lighten-1' : ''"-->
            </v-flex>
        </v-layout>
    </v-form>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import ContextAutocompleteSubFormLayout from './ContextAutocompleteSubFormLayout'
  import CampaignAutocomplete from './CampaignAutocomplete'
  import { validationMixin } from 'vuelidate'
  import { required, maxLength } from 'vuelidate/lib/validators'
  import { requiredAutocompleteObject } from '../util'

  const campaignErrors = ($v) => {
    const errors = []
    !$v.item.campaign.requiredAutocompleteObject && errors.push('Campaign is required.')
    return errors
  }

  const numErrors = ($v) => {
    const errors = []
    !$v.item.num.required && errors.push('Bucket number is required.')
    !$v.item.num.maxLength && errors.push('Bucket number must be max 4 character length.')
    return errors
  }

  const contextErrors = ($v) => {
    const errors = []
    !$v.item.context.requiredAutocompleteObject && errors.push('Context is required.')
    return errors
  }

  export default {
    name: 'bucket-edit-data-form',
    extends: BaseDataForm,
    components: {
      CampaignAutocomplete,
      ContextAutocompleteSubFormLayout
    },
    mixins: [
      validationMixin
    ],
    validations: {
      item: {
        context: {requiredAutocompleteObject},
        campaign: {requiredAutocompleteObject},
        num: {required, maxLength: maxLength(4)},
      }
    },
    computed: {
      validationErrors () {
        return {
          context: contextErrors(this.$v),
          num: numErrors(this.$v),
          campaign: campaignErrors(this.$v),
        }
      },
      site () {
        return this.item.context && this.item.context.area.site ? this.item.context.area.site : {}
      }
      /*isReadOnly () {
        return !!this.item.id || !this.$store.getters['account/isSuperUser']
      }*/
    },
    watch: {
      item: {
        /**
         * The HTTP queried does not have the nested "site" property inside "area"
         * @param {Object} item
         */
        handler (item) {
          if (item && item.campaign && item.context) {
            item.context.area.site = item.campaign.site
          }
        }
      }
    },
    methods: {
      /**
       * Set not input driven (e.g. props) area value
       * @param bucket
       */
      setSelectedContext (context) {
        this.selectedArea = area
        this.addToAreas(area)
      }
    }
  }
</script>
