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
            label="Name"
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
  import { required } from 'vuelidate/lib/validators'
  import {requiredAutocompleteObject} from '../util'

  const nameErrors = ($v) => {
    const errors = []
    !$v.item.name.required && errors.push('Phase\'s name is required.')
    return errors
  }

  const siteErrors = ($v) => {
    const errors = []
    !$v.item.site.requiredAutocompleteObject && errors.push('Site is required.')
    return errors
  }

  export default {
    name: 'phase-edit-data-form',
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
        name: { required }
      }
    },
    computed: {
      validationErrors() {
        return {
          site: siteErrors(this.$v),
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
                return item.id === id
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
