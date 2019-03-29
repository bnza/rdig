<template>
    <div>
        <v-layout row wrap>
            <v-flex class="xs3">
                <v-text-field
                        label="Site (code)"
                        type="text"
                        :value="site.code"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
            <v-flex class="xs9">
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
            <v-flex class="xs3">
                <v-autocomplete
                        label="Area (code)"
                        menu-props="bottom"
                        :items="autocomplete.areas"
                        v-model="selectedArea"
                        item-text="uCode"
                        item-value="id"
                        :search-input.sync="searchInput"
                        :loading="loading"
                        return-object
                        persistent-hint
                        hint="Site area, prepending site code (e.g. TH.A). Required"
                        :error-messages="errorMessages"
                        required
                />
            </v-flex>
            <v-flex class="xs9">
                <v-text-field
                        label="Area (name)"
                        type="text"
                        :value="selectedArea.name"
                        class="readonly-field"
                        color="grey lighten-1"
                        readonly
                />
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
  import { debounce } from '../util'

  export default {
    name: 'AreaAutocompleteSubFormLayout',
    data () {
      return {
        autocomplete: {
          areas: [],
          area: {},
        },
        searchInput: '',
        loading: false,
      }
    },
    props: {
      area: {
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
        return this.selectedArea.site || {}
      },
      selectedArea: {
        get () {
          return this.autocomplete.area || {}
        },
        set (value) {
          this.autocomplete.area = value
        }
      },
    },
    methods: {
      /**
       * Adds the given area to the autocomplete "items" prop.
       * Needed for display not fetched data
       * @param {Object} area
       */
      addToAreas(area) {
        this.autocomplete.areas.push(this.addUniqueCodeToArea(area))
      },
      /**
       * Adds code property to bucket object
       * @param {Object} bucket
       * @return {Object} bucket
       */
      addUniqueCodeToArea(area) {
        if (!area.uCode) {
          area.uCode = this.getAreaUniqueCode(area);
        }
        return area;
      },
      fetchAreas: debounce(function (pattern) {
        if (typeof pattern === 'string') {
          this.loading = true
          const config = {
            method: 'get',
            url: `data/area?re=${pattern}`
          }
          this.$store.dispatch('requests/perform', config).then(
            (response) => {
              this.loading = false
              this.autocomplete.areas = response.data.map(this.addUniqueCodeToArea)
            }
          ).catch(
            (error) => {
              this.loading = false
            }
          )
        }
      }, 250),
      /**
       * Returns area unique code e.g. "TH.A"
       * @param area
       * @return {string} the unique code
       */
      getAreaUniqueCode (area) {
        if (area.site) {
          return `${area.site.code}.${area.code}`
        }
        return ''
      },
      /**
       * Set not input driven (e.g. props) area value
       * @param bucket
       */
      setSelectedArea (area) {
        this.selectedArea = area
        this.addToAreas(area);
      }
    },
    watch: {
      searchInput (val) {
        val && this.fetchAreas(val)
      },
      area (val) {
        if (val) {
          this.setSelectedArea(val)
        }
      },
      selectedArea (value) {
        if (value) {
          this.$emit('update:area', value)
        }
      }
    }
  }
</script>
