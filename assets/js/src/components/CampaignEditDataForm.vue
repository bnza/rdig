<template>
    <v-form>
        <v-select
            label="Site"
            menu-props="bottom"
            :items="sites"
            v-model="item.site"
            item-text="name"
            item-value="id"
            return-object
            :error-messages="validationErrors.site"
            :disabled="!!parent__"
        />
        <v-text-field
            label="Year"
            v-model="item.year"
            :error-messages="validationErrors.year"
            mask="####"
            :counter="4"
            :disabled="isRequestPending"
            required
        />
    </v-form>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import { validationMixin } from 'vuelidate'
  import { required, between } from 'vuelidate/lib/validators'
  import {requiredAutocompleteObject} from '../util'

  const yearErrors = ($v) => {
    const errors = []
    !$v.item.year.between && errors.push('Campaign\'s year must be within 2000 and 2099')
    !$v.item.year.required && errors.push('Campaign\'s year is required.')
    return errors
  }

  const siteErrors = ($v) => {
    const errors = []
    !$v.item.site.required && errors.push('Site is required.')
    return errors
  }

  export default {
    name: 'campaign-edit-data-form',
    extends: BaseDataForm,
    mixins: [
      validationMixin
    ],
    data () {
      return {
        sites: []
      }
    },
    validations: {
      item: {
        site: { requiredAutocompleteObject },
        year: { required, between }
      }
    },
    computed: {
      validationErrors() {
        return {
          site: siteErrors(this.$v),
          name: yearErrors(this.$v),
        }
      },
    },
    methods: {
      fetchSites () {
        const config = {
          method: 'get',
          url: `data/site`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.sites = response.data.items
            if (this.parent__) {
              const id = this.parent__.id
              this.site = this.sites.find(function (item) {
                return item.id == id
              })
            }
          }
        )
      }
    },
    created () {
      this.fetchSites()
    }
  }
</script>
