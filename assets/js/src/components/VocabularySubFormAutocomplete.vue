<template>
    <v-autocomplete
            :label=label
            menu-props="bottom"
            :items="autocomplete.terms"
            v-model="selectedTerm"
            item-text="value"
            item-value="id"
            :search-input.sync="searchInput"
            :loading="loading"
            return-object
            :error-messages="errorMessages"
            persistent-hint
            :hint="hint"
            :required="required"
    />
</template>

<script>
  import {debounce} from '../util'

  export default {
    name: 'VocabularySubFormAutocomplete',
    data () {
      return {
        autocomplete: {
          terms: [],
          term: {},
        },
        searchInput: '',
        loading: false,
      }
    },
    props: {
      errorMessages: {
        type: Array,
        default: () => []
      },
      hint: {
        type: String,
        default: ''
      },
      label: {
        type: String,
        required: true
      },
      required: {
        type: Boolean,
        default: false
      },
      term: {
        type: Object,
        default: () => {}
      },
      vocabulary: {
        type: Object,
        required: true,
        validator: function (value) {
          return value.hasOwnProperty('type') && value.hasOwnProperty('name')
        }
      }
    },
    computed: {
      selectedTerm: {
        get () {
          return this.autocomplete.term;
        },
        set (value) {
          return this.autocomplete.term = value
        }
      }
    },
    methods: {
      fetchVocabulary: debounce(
        /**
         * Fetch vocabulary values for v-select entries filling the corresponding vocabularies array
         * which match the item value (eg. item.firing -> vocabularies.p.firing).
         * If no item key is provided the vocabulary name is used instead
         * @param type
         * @param name
         * @param pattern
         */
        function ({type, name}, pattern) {
          if (typeof pattern === 'string') {
            this.loading = true
            const config = {
              method: 'get',
              url: `voc/${type}/${name}/re/${pattern}`
            }
            this.$store.dispatch('requests/perform', config).then(
              (response) => {
                this.loading = false
                // Prepend empty item
                let data = [{id: '', value: ''}, ...response.data]
                this.autocomplete.terms = data
              }
            ).catch(
              (error) => {
                this.loading = false
              }
            )
          }
        }, 250),
      /**
       * Set not input driven (e.g. props) vocabulary term value
       * @param term
       */
      setSelectedTerm (term) {
        this.selectedTerm = term
        this.autocomplete.terms.push({id: '', value: ''})
        this.autocomplete.terms.push(term)
      }
    },
    watch: {
      searchInput (val) {
        val && this.fetchVocabulary(this.vocabulary, val)
      },
      term (val) {
        if (val) {
          this.setSelectedTerm(val)
        }
      },
      selectedTerm (newValue, oldValue) {
        if (newValue !== oldValue) {
          this.$emit('update:term', newValue)
        }
      }
    }
  }
</script>

<style scoped>

</style>
