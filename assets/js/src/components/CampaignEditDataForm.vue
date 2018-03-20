<template>
    <v-form>
        <v-select
            label="Site"
            bottom
            :items="sites"
            v-model="siteId"
            item-text="name"
            item-value="id"
            :error-messages="siteIdErrors"
            :disabled="!!parent__"
            @input="formMxValidate('siteId')"
            @blur="formMxValidate('siteId')"
        />
        <v-text-field
            label="Year"
            v-model="year"
            :error-messages="yearErrors"
            mask="####"
            :counter="4"
            @input="formMxValidate('year')"
            @blur="formMxValidate('year')"
            :disabled="isRequestPending"
            required
        />
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import { validationMixin } from 'vuelidate'
  import { required, between } from 'vuelidate/lib/validators'

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
      siteId: { required },
      year: { required, between: between(2000, 2099) }
    },
    computed: {
      site: {
        get () {
          return this.item.site || {}
        },
        set (value) {
          Vue.set(this.item, 'site', value)
        }
      },
      siteId: {
        get () {
          return this.item.site ? this.item.site.id : undefined
        },
        set (value) {
          if (!this.item.site) {
            Vue.set(this.item, 'site', {})
          }
          Vue.set(this.item.site, 'id', value)
        }
      },
      year: {
        get () {
          return this.item.year
        },
        set (value) {
          Vue.set(this.item_, 'year', value)
        }
      },
      yearErrors () {
        const errors = []
        if (!this.$v.year.$dirty) return errors
        !this.$v.year.between && errors.push('Campaign\'s year must be within 2000 and 2099')
        !this.$v.year.required && errors.push('Campaign\'s year is required.')
        return errors
      },
      siteIdErrors () {
        const errors = []
        if (!this.$v.siteId.$dirty) return errors
        !this.$v.siteId.required && errors.push('Site is required.')
        return errors
      }
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