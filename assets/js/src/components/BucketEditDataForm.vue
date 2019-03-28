<template>
    <v-form>
        <v-layout
            v-if="!item.id && (!parent__ || (parent__ && !parent__.table !== 'campaign'))"
            row
            wrap
        >
            <v-flex xs1 v-if="parent__">
                <v-text-field
                    type="text"
                    :value="contextSiteCodePrefix"
                    class="readonly-field"
                    color="grey lighten-1"
                    readonly
                />
            </v-flex>
            <v-flex :class="{xs11: parent__, xs12:!parent__}" >
                <v-autocomplete
                    label="Campaign"
                    bottom
                    :items="campaigns"
                    v-model="campaignId"
                    item-text="name"
                    item-value="id"
                    :error-messages="campaignIdErrors"
                    :search-input.sync="searchCampaign"
                    @blur="formMxValidate('campaignId')"
                    :loading="loadingCampaigns"
                />
            </v-flex>
        </v-layout>
        <v-layout
            v-else-if="campaign"
            row
            wrap
        >
            <v-flex xs3 >
                <v-text-field
                    label="Site"
                    type="text"
                    :value="campaign.site.code"
                    class="readonly-field"
                    color="grey lighten-1"
                    readonly
                />
            </v-flex>
            <v-flex xs9>
                <v-text-field
                    label="Campaign"
                    type="text"
                    :value="campaign.year"
                    class="readonly-field"
                    color="grey lighten-1"
                    readonly
                />
            </v-flex>
        </v-layout>
        <v-layout
            v-if="!item.id && (!parent__ || (parent__ && !parent__.table === 'campaign'))"
            row
            wrap
            align-center
        >
            <v-flex xs1 v-if="parent__">
                <v-text-field
                    type="text"
                    :value="campaignSiteCodePrefix"
                    class="readonly-field"
                    color="grey lighten-1"
                    readonly
                />
            </v-flex>
            <v-flex :class="{xs11: parent__, xs12:!parent__}" >
                <v-select
                    label="Context"
                    bottom
                    mask="####"
                    :items="contexts"
                    v-model="contextId"
                    item-text="name"
                    item-value="id"
                    :error-messages="contextIdErrors"
                    :search-input.sync="searchContext"
                    @blur="formMxValidate('contextId')"
                    autocomplete
                    :loading="loadingContexts"
                    :disabled="!campaignSiteCode"
                />
            </v-flex>
        </v-layout>
        <v-layout
            v-else-if="context"
            row
            wrap
        >
            <v-flex xs3 >
                <v-text-field
                    label="Area"
                    type="text"
                    :value="context.area.code"
                    class="readonly-field"
                    color="grey lighten-1"
                    readonly
                />
            </v-flex>
            <v-flex xs9>
                <v-text-field
                    label="Context"
                    type="text"
                    :value="context.num"
                    class="readonly-field"
                    color="grey lighten-1"
                    readonly
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12>
                <v-text-field
                    label="Number"
                    type="text"
                    v-model="item.num"
                    @input="formMxValidate('num')"
                    :readonly="isReadOnly"
                    :hint="isReadOnly ? 'Only superuser can change bucket number' : ''"
                    :color="isReadOnly ? 'grey lighten-1' : ''"
                />
            </v-flex>
        </v-layout>
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import AreaReadFieldsItem from './AreaReadFieldsItem'
  import { validationMixin } from 'vuelidate'
  import { required, maxLength } from 'vuelidate/lib/validators'
  import {debounce} from '../util'

  export default {
    name: 'bucket-edit-data-form',
    extends: BaseDataForm,
    components: {
      AreaReadFieldsItem
    },
    mixins: [
      validationMixin
    ],
    data () {
      return {
        campaigns: [],
        contexts: [],
        searchCampaign: null,
        searchContext: null,
        loadingCampaigns: false,
        loadingContexts: false
      }
    },
    validations: {
      campaignId: { required },
      contextId: { required },
      num: {}
//      type: { required }
    },
    computed: {
      isReadOnly () {
        return !!this.item.id || !this.$store.getters['account/isSuperUser']
      },
      campaign: {
        get () {
          return this.item.campaign || { site: {} }
        },
        set (value) {
          Vue.set(this.item, 'campaign', value)
        }
      },
      campaignId: {
        get () {
          return this.campaign.id
        },
        set (value) {
          if (!this.item.campaign) {
            Vue.set(this.item, 'campaign', {})
          }
          Vue.set(this.campaign, 'id', value)
        }
      },
      campaignSiteCode () {
        if (this.campaignId) {
          const campaignCode = this.campaigns.find((item) => {
            return item.id === this.campaignId
          })
          return campaignCode ? campaignCode.name.split('.', 1)[0] : undefined
        }
      },
      campaignSiteCodePrefix () {
        return this.campaignSiteCode ? `${this.campaignSiteCode}.` : ''
      },
      context: {
        get () {
          return this.item.context || { area: {} }
        },
        set (value) {
          Vue.set(this.item, 'context', value)
        }
      },
      contextId: {
        get () {
          return this.item.context ? this.item.context.id : undefined
        },
        set (value) {
          if (!this.item.context) {
            Vue.set(this.item, 'context', {})
          }
          Vue.set(this.item.context, 'id', value)
        }
      },
      contextSiteCode () {
        if (this.contextId) {
          return this.item.context.area.site.code
        }
      },
      contextSiteCodePrefix () {
        return this.contextSiteCode ? `${this.contextSiteCode}.` : ''
      },
      type: {
        get () {
          return this.item.type
        },
        set (value) {
          Vue.set(this.item_, 'type', value.toUpperCase())
        }
      },
      typeName () {
        return this.type ? this.$store.getters.bucketTypeName(this.type).name : undefined
      },
/*      num: {
        get () {
          return this.item.num
        },
        set (value) {
          Vue.set(this.item, 'num', value)
        }
      },*/
      typeErrors () {
        const errors = []
        if (!this.$v.type.$dirty) return errors
        !this.$v.type.required && errors.push('Bucket type is required.')
        return errors
      },
      campaignIdErrors () {
        const errors = []
        if (!this.$v.campaignId.$dirty) return errors
        !this.$v.campaignId.required && errors.push('Campaign is required.')
        return errors
      },
      contextIdErrors () {
        const errors = []
        if (!this.$v.contextId.$dirty) return errors
        !this.$v.contextId.required && errors.push('Context is required.')
        return errors
      }
    },
    watch: {
      searchCampaign (val) {
        val && this.fetchCampaigns(val)
      },
      searchContext (val) {
        val && this.fetchContexts(val)
      }
    },
    methods: {
      fetchCampaigns : debounce(function (pattern) {
        this.loading = true
        if (typeof pattern === 'string') {
          const contextSiteCodePrefix = this.contextSiteCodePrefix
          const config = {
            method: 'get',
            url: `data/campaign?re=${this.contextSiteCodePrefix}${pattern.toUpperCase()}`
          }
          this.$store.dispatch('requests/perform', config).then(
            (response) => {
              this.loading = false
              this.campaigns = response.data.map(function(item) {
                item.name = contextSiteCodePrefix ? item.name.substr(contextSiteCodePrefix.length) : item.name
                return item;
              })
            }
          ).catch(
            (error) => {
              this.loading = false
            }
          )
        }
      }, 250),
      fetchContexts : debounce(function (pattern) {
        this.loading = true
        if (typeof pattern === 'string') {
          const config = {
            method: 'get',
            url: `data/context?re=${this.campaignSiteCodePrefix}${pattern.toUpperCase()}`
          }
          this.$store.dispatch('requests/perform', config).then(
            (response) => {
              this.loading = false
              this.contexts = response.data
            }
          ).catch(
            (error) => {
              this.loading = false
            }
          )
        }
      }, 250)
    },
    mounted () {
      if (!this.campaignId && this.parent__ && this.parent__.table === 'campaign') {
        this.loadingCampaigns = true
        const config = {
          method: 'get',
          url: `data/campaign/${this.parent__.id}`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.loadingCampaigns = false
            Vue.set(this.item, 'campaigns', response.data)
          }
        ).catch(
          (error) => {
            this.loadingCampaigns = false
            this.loading = false
          }
        )
      }
      if (!this.contextId && this.parent__ && this.parent__.table === 'context') {
        this.loadingContexts = true
        const config = {
          method: 'get',
          url: `data/context/${this.parent__.id}`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.loadingContexts = false
            Vue.set(this.item, 'context', response.data)
          }
        ).catch(
          (error) => {
            this.loadingContexts = false
            this.loading = false
          }
        )
      }
    }
  }
</script>
