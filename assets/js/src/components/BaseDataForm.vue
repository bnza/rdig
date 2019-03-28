<script>
  import Vue from 'vue'
  import BaseDataComponent from './BaseDataComponent'
  import FormMx from '../mixins/FormMx'
  import {debounce} from '../util'

  export default {
    name: 'base-data-form',
    extends: BaseDataComponent,
    mixins: [
      FormMx
    ],
    props: {
      item__: {
        type: Object,
        validator(value) {
          return typeof value === 'undefined' || value.hasOwnProperty('id')
        }
      }
    },
    data() {
      return {
        item_: {},
        /*vocabularies: {
          f: {},
          o: {},
          p: {},
          s: {}
        }*/
      }
    },
    computed: {
      id() {
        return this.id__ || this.item.id
      },
      item: {
        get() {
          return Object.keys(this.item_).length > 0 ? this.item_ : this.item__ || this.item_
        },
        set(value) {
          this.item_ = JSON.parse(JSON.stringify(value))
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
         * @param itemKey
         */
        function (type, name, pattern, itemKey) {
          this.loading = true
          if (typeof pattern === 'string') {
            const config = {
              method: 'get',
              url: `voc/${type}/${name}/re/${pattern}`
            }
            this.$store.dispatch('requests/perform', config).then(
              (response) => {
                this.loading = false
                // Prepend empty item
                let data = [{id: '', value: ''}, ...response.data]
                itemKey = itemKey || name
                Vue.set(this.vocabularies[type], itemKey, data)
              }
            ).catch(
              (error) => {
                this.loading = false
              }
            )
          }
        }, 250),
      update() {
        this.formMxUpdate().then(
          () => {
            this.$emit('sync')
          }
        ).catch(
          () => {
            // TODO workaround
            // clone data item detaching it from store
            this.item = this.item
          }
        )
      },
      create() {
        this.formMxCreate().then(
          () => {
            this.$emit('sync')
          }
        ).catch(
          (error) => {
            // TODO workaround
            // clone data item detaching it from store
            this.item = this.item
          }
        )
      },
      delete() {
        this.formMxDelete().then(
          () => {
            this.$emit('sync')
          }
        ).catch(
          () => {
          }
        )
      }
    },
    watch: {
      id(value) {
        if (!this.item || this.item.id !== value) {
          this.formMxRead()
        }
      }
    },
    created() {
      if (this.item__) {
        this.item_ = this.item__
      } else if (this.id__) {
        this.formMxRead().then((response) => {
          this.$emit('ready', this.item)
        })
      }
    }
  }
</script>

<style scoped>
    .text-strong >>> input[type="text"] {
        font-weight: bold;
    }

    .readonly-field >>> input:read-only {
        color: rgba(0, 0, 0, 0.5);
    }
</style>
