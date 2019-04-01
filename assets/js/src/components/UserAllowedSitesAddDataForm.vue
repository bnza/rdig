<template>
    <v-form>
        <v-select
            label="Select site"
            single-line
            bottom
            :items="sites"
            v-model="item.siteId"
            item-text="name"
            item-value="id"
            :error-messages="siteIdErrors"
        />
    </v-form>
</template>

<script>
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
      item: {
        siteId: { required }
      }
    },
    computed: {
      siteIdErrors () {
        const errors = []
        !this.$v.item.siteId.required && errors.push('Site is required.')
        return errors
      }
    },
    methods: {
      fetchSites () {
        const config = {
          method: 'get',
          url: `admin/user/${this.parent__.id}/user-denied-sites`
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
