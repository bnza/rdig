<template>
    <v-autocomplete
            label="Campaign"
            menu-props="bottom"
            :items="autocomplete.campaigns"
            v-model="selectedCampaign"
            item-text="year"
            item-value="id"
            :search-input.sync="searchInput"
            :loading="loading"
            return-object
            :error-messages="errorMessages"
            persistent-hint
            :hint="hint"
            required
            :readonly="!site"
    />
</template>

<script>
  import { debounce } from '../util'

  export default {
    name: 'CampaignAutocomplete',
    data () {
      return {
        autocomplete: {
          campaigns: [],
          campaign: {},
        },
        searchInput: '',
        loading: false,
      }
    },
    props: {
      site: {
        type: Object,
        default: {}
      },
      campaign: {
        type: Object,
        default: () => {}
      },
      errorMessages: {
        type: Array,
        default: () => []
      },
      hint: {
        type: String,
        default: ''
      },
    },
    computed: {
/*      site () {
        return this.selectedCampaign.site || {}
      },*/
      selectedCampaign: {
        get () {
          return this.autocomplete.campaign
        },
        set (value) {
          return this.autocomplete.campaign = value
        }
      }
    },
    methods: {
      fetchCampaigns: debounce(function (pattern) {
        pattern = pattern || ''
        this.loading = true
        const config = {
          method: 'get',
          url: `data/campaign?re=${this.site.code}.${pattern}`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.loading = false
            this.autocomplete.campaigns = response.data
          }
        ).catch(
          (error) => {
            this.loading = false
          }
        )
      }, 250),
    },
    watch: {
      searchInput (newValue, oldValue) {
        if (newValue && newValue !== oldValue) {
          this.fetchCampaigns(newValue)
        }
      },
      campaign (val) {
        if (val) {
          this.autocomplete.campaigns.push(val)
          this.selectedCampaign = val
        }
      },
      selectedCampaign (value) {
        if (value) {
          this.$emit('update:campaign', value)
        }
      }
    }
  }
</script>

<style scoped>

</style>
