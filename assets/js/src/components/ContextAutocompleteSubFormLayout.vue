<template>
    <div>
        <v-layout row wrap>
            <v-flex
                    class="xs4"
                    data-test="siteCodeFlex"
            >
                <v-text-field
                        label="Site (code)"
                        type="text"
                        :value="site.code"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
            <v-flex
                    class="xs8"
                    data-test="siteNameFlex"
            >
                <v-text-field
                        label="Site (name)"
                        type="text"
                        :value="site.name"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex
                    class="xs4"
                    data-test="areaCodeFlex"
            >
                <v-text-field
                        label="Area (code)"
                        type="text"
                        :value="area.code"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
            <v-flex
                    class="xs8"
                    data-test="areaNameFlex"
            >
                <v-text-field
                        label="Area (name)"
                        type="text"
                        :value="area.name"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex
                    class="xs4"
                    data-test="contextCodeFlex"
            >
                <v-autocomplete
                        label="Context (code)"
                        menu-props="bottom"
                        :items="autocomplete.contexts"
                        v-model="selectedContext"
                        item-text="code"
                        item-value="id"
                        :search-input.sync="searchInput"
                        :loading="loading"
                        return-object
                        persistent-hint
                        no-filter
                        hint="Context number, prepending site code (e.g. TH.108). Required"
                        :error-messages="errorMessages"
                        required
                />
            </v-flex>
            <v-flex
                    class="xs4"
                    data-test="contextTypeFlex"
            >
                <v-text-field
                        label="Context (type)"
                        type="text"
                        :value="getContextTypeName(selectedContext.type)"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
            <v-flex
                    class="xs4"
                    data-test="contextNumFlex"
            >
                <v-text-field
                        label="Context (number)"
                        type="text"
                        :value="selectedContext.num"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
  import {debounce} from '../util'

  export default {
    name: 'ContextAutocompleteSubFormLayout',
    data () {
      return {
        autocomplete: {
          contexts: [],
          context: {},
        },
        searchInput: '',
        loading: false,
      }
    },
    props: {
      context: {
        type: Object,
        default: () => {}
      },
      errorMessages: {
        type: Array,
        default: () => []
      }
    },
    computed: {
      site() {
        return this.area.site || {}
      },
      area() {
        return this.selectedContext.area || {};
      },
      selectedContext: {
        get () {
          return this.autocomplete.context || {}
        },
        set (value) {
          this.autocomplete.context = value
        }
      },
    },
    methods: {
      /**
       * Adds the given contexts to the autocomplete "items" prop.
       * Needed for display not fetched data
       * @param {Object} context
       */
      addToContexts(context) {
        this.autocomplete.contexts.push(this.addCodeToContext(context))
      },
      /**
       * Adds code property to bucket object
       * @param {Object} bucket
       * @return {Object} bucket
       */
      addCodeToContext(context) {
        if (!context.code) {
          context.code = this.getContextCode(context);
        }
        return context;
      },
      fetchContexts : debounce(function (pattern) {
        if (typeof pattern === 'string') {
          this.loading = true
          const config = {
            method: 'get',
            url: `data/context?re=${pattern.toUpperCase()}`
          }
          this.$store.dispatch('requests/perform', config).then(
            (response) => {
              this.loading = false
              this.autocomplete.contexts = response.data.map(this.addCodeToContext)
            }
          ).catch(
            (error) => {
              this.loading = false
            }
          )
        }
      }, 250),
      /**
       * Returns area unique code e.g. "TH.218"
       * @param context
       * @return {string} the unique code
       */
      getContextCode (context) {
        if (context.area && context.area.site) {
          return `${context.area.site.code}.${context.num}`
        }
        return ''
      },
      getContextTypeName (key) {
        if (key) {
          const context = this.$store.state.contextTypes.find((item) => (key) => {
            return item.id === key
          })
          return context.name
        }
      },
      /**
       * Set not input driven (e.g. props) context value
       * @param context
       */
      setSelectedContext (context) {
        this.selectedContext = context
        this.addToContexts(context);
      }
    },
    watch: {
      searchInput (newValue, oldValue) {
        if (newValue && newValue !== oldValue) {
            this.fetchContexts(newValue)
        }
      },
      context (val) {
        if (val) {
          this.setSelectedContext(val)
        }
      },
      selectedContext(value) {
        if (value) {
          this.$emit('update:context', value)
        }
      }
    }
  }
</script>
