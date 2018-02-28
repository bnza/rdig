<template>
    <v-form>
        <v-select
            label="Select site"
            single-line
            bottom
            :items="sites"
            v-model="siteId"
            item-text="name"
            item-value="id"
            :error-messages="siteIdErrors"
            @input="formMxValidate('siteId')"
            @blur="formMxValidate('siteId')"
        />
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import { validationMixin } from 'vuelidate'
  import { required } from 'vuelidate/lib/validators'

  export default {
    name: 'user-allowed-sites-add-data-form',
    extends: BaseDataForm,
    mixins: [
      validationMixin
    ],
    data () {
      return {
        prefix_: 'admin',
        table_: 'user-allowed-sites',
        sites: []
      }
    },
    validations: {
      siteId: { required }
    },
    computed: {
      siteId: {
        get () {
          return this.item.siteId
        },
        set (value) {
          Vue.set(this.item, 'siteId', value)
        }
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
          url: `admin/user/${this.parent.id}/user-denied-sites`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.sites = response.data
          }
        )
      }
    },
    created () {
      this.fetchSites()
    }
  }
</script>