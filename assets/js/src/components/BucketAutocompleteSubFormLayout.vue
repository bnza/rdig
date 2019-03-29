<template>
    <div>
        <v-layout row wrap>
            <v-flex class="xs4">
                <v-text-field
                        label="Site"
                        type="text"
                        :value="site.name"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
            <v-flex class="xs4">
                <v-text-field
                        label="Year"
                        type="text"
                        :value="campaign.year"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
            <v-flex class="xs4">
                <v-text-field
                        label="Area"
                        type="text"
                        :value="area.name"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex class="xs6">
                <v-text-field
                        label="Context"
                        type="text"
                        :value="contextCode"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
            <v-flex class="xs6">
                <v-autocomplete
                        label="Bucket"
                        menu-props="bottom"
                        :items="autocomplete.buckets"
                        v-model="selectedBucket"
                        item-text="code"
                        item-value="id"
                        :search-input.sync="searchInput"
                        :loading="loading"
                        return-object
                        persistent-hint
                        hint="This field is required"
                        :error-messages="errorMessages"
                        no-filter
                        required
                />
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
  import { debounce } from '../util'

  export default {
    name: 'BucketAutocompleteSubFormLayout',
    data () {
      return {
        autocomplete: {
          buckets: [],
          bucket: {},
        },
        searchInput: '',
        loading: false,
      }
    },
    props: {
      bucket: {
        type: Object,
        default: () => {}
      },
      errorMessages: {
        type: Array,
        default: () => []
      }
    },
    computed: {
      area () {
        return this.context.area || {}
      },
      campaign () {
        return this.selectedBucket.campaign || {}
      },
      context () {
        return this.selectedBucket.context || {}
      },
      contextCode () {
        const context = this.context
        return context.type ? `${context.type}.${context.num}` : undefined
      },
      selectedBucket: {
        get() {
          return this.autocomplete.bucket
        },
        set (value) {
          this.autocomplete.bucket = value;
        }
      },
      site () {
        return this.campaign.site || {}
      },
    },
    methods: {
      /**
       * Adds the given bucket to the autocomplete "items" prop.
       * Needed for display not fetched data
       * @param {Object} bucket
       */
      addToBuckets(bucket) {
        this.autocomplete.buckets.push(this.addCodeToBucket(bucket))
      },
      /**
       * Adds code property to bucket object
       * @param {Object} bucket
       * @return {Object} bucket
       */
      addCodeToBucket(bucket) {
        if (!bucket.code) {
          bucket.code = this.getBucketCode(bucket);
        }
        return bucket;
      },
      fetchBuckets: debounce(function (pattern) {
        this.loading = true
        if (typeof pattern === 'string') {
          const config = {
            method: 'get',
            url: `data/bucket/re/${pattern}`
          }
          this.$store.dispatch('requests/perform', config).then(
            (response) => {
              this.loading = false
              this.autocomplete.buckets = response.data
            }
          ).catch(
            (error) => {
              this.loading = false
            }
          )
        }
      }, 250),
      /**
       * @param bucket
       * @return {string}
       */
      getBucketCode (bucket) {
        if (bucket.campaign) {
          const year = bucket.campaign.year.toString().substr(2)
          //return `${bucket.campaign.site.code}${year}P${bucket.num}`
          return `${bucket.campaign.site.code}.${year}.${bucket.num}`
        }
        return ''
      },
      /**
       * Set not input driven (e.g. props) bucket value
       * @param bucket
       */
      setSelectedBucket (bucket) {
        this.selectedBucket = bucket
        this.addToBuckets(bucket);
      },
    },
    watch: {
      searchInput (val) {
        val && this.fetchBuckets(val)
      },
      bucket (val) {
        if (val) {
          this.setSelectedBucket(val)
        }
      },
      selectedBucket (newValue, oldValue) {
        if (newValue !== oldValue) {
          this.$emit('update:bucket', newValue)
        }
      }
    }
  }
</script>

<style scoped>

</style>
