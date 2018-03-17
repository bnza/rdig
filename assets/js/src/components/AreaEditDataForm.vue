<template>
    <v-form>
        <v-select
            label="Site"
            bottom
            :items="sites"
            v-model="site"
            item-text="name"
            item-value="id"
            :error-messages="siteIdErrors"
            :disabled="!!parent__"
            @input="formMxValidate('siteId')"
            @blur="formMxValidate('siteId')"
        />
        <v-text-field
            label="Code"
            v-model="code"
            :error-messages="codeErrors"
            :counter="2"
            @input="formMxValidate('code')"
            @blur="formMxValidate('code')"
            :disabled="isRequestPending"
            required
        />
        <v-text-field
            label="Name"
            type="text"
            v-model="name"
            :error-messages="nameErrors"
            @input="formMxValidate('name')"
            @blur="formMxValidate('name')"
            :disabled="isRequestPending"
            required
        />
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import { validationMixin } from 'vuelidate'
  import { required, maxLength } from 'vuelidate/lib/validators'

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
      siteId: { required },
      code: { required, maxLength: maxLength(2) },
      name: { required }
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
          Vue.set(this.item.site, 'name', '000')
        }
      },
      code: {
        get () {
          return this.item.code
        },
        set (value) {
          Vue.set(this.item_, 'code', value.toUpperCase())
        }
      },
      name: {
        get () {
          return this.item.name
        },
        set (value) {
          Vue.set(this.item, 'name', value)
        }
      },
      codeErrors () {
        const errors = []
        if (!this.$v.code.$dirty) return errors
        !this.$v.code.maxLength && errors.push('Area code must be maximum 2 characters long')
        !this.$v.code.required && errors.push('Area code is required.')
        return errors
      },
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.required && errors.push('Area name is required.')
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