<template>
    <v-autocomplete
            label="Phase"
            menu-props="bottom"
            :items="autocomplete.items"
            v-model="selectedItem"
            item-text="name"
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
    name: 'PhaseAutocomplete',
    data () {
      return {
        autocomplete: {
          items: [],
          item: {},
        },
        searchInput: '',
        loading: false,
      }
    },
    props: {
      site: {
        type: Object,
        default: () => {}
      },
      item: {
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
      selectedItem: {
        get () {
          return this.autocomplete.item
        },
        set (value) {
          return this.autocomplete.item = value
        }
      }
    },
    methods: {
      fetchItems: debounce(function (pattern) {
        pattern = pattern || ''
        this.loading = true
        const config = {
          method: 'get',
          url: `data/phase/?re=${this.site.code}.${pattern}`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.loading = false
            this.autocomplete.items = [{id: '', name: ''}, ...response.data]
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
          this.fetchItems(newValue)
        }
      },
      item (val) {
        if (val) {
          this.autocomplete.items.push(val)
          this.selectedItem = val
        }
      },
      selectedItem (value) {
        if (value) {
          this.$emit('update:item', value)
        }
      }
    }
  }
</script>

<style scoped>

</style>
