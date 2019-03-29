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
            label="Code"
            v-model="item.code"
            :error-messages="validationErrors.code"
            :counter="3"
            :disabled="isRequestPending"
            required
        />
        <v-text-field
            label="Name"
            type="text"
            v-model="item.name"
            :error-messages="validationErrors.name"
            :disabled="isRequestPending"
            required
        />
    </v-form>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import { validationMixin } from 'vuelidate'
  import { required, maxLength } from 'vuelidate/lib/validators'
  import {requiredAutocompleteObject} from '../util'

  const siteErrors = ($v) => {
    const errors = []
    !$v.item.site.requiredAutocompleteObject && errors.push('Site is required.')
    return errors
  }

  const codeErrors = ($v) => {
    const errors = []
    !$v.item.code.required && errors.push('Code is required.')
    !$v.item.code.maxLength && errors.push('Code must be 2 characters length.')
    return errors
  }

  const nameErrors = ($v) => {
    const errors = []
    !$v.item.name.required && errors.push('Name is required.')
    return errors
  }

  export default {
    name: 'area-edit-data-form',
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
        code: { required, maxLength: maxLength(3) },
        name: { required }
      }
    },
    computed: {
      validationErrors() {
        return {
          site: siteErrors(this.$v),
          code: codeErrors(this.$v),
          name: nameErrors(this.$v),
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
