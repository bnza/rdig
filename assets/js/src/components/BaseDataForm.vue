<script>
  import BaseDataComponent from './BaseDataComponent'
  import FormMx from '../mixins/FormMx'
  export default {
    name: 'base-data-form',
    extends: BaseDataComponent,
    mixins: [
      FormMx
    ],
    props: {
      id__: {
        type: [Number, String],
        validator (value) {
          return /^\d*,?\d*$/.test(value)
        }
      },
      item__: {
        type: Object,
        validator (value) {
          return typeof value === 'undefined' || value === {} || value.hasOwnProperty('id')
        }
      }
    },
    data () {
      return {
        item_: {}
      }
    },
    computed: {
      id () {
        return this.item.id || this.id__
      },
      item: {
        get () {
          return Object.keys(this.item_).length > 0 ? this.item_ : this.item__ || this.item_
        },
        set (value) {
          this.item_ = JSON.parse(JSON.stringify(value))
        }
      }
    },
    methods: {
      update () {
        this.formMxUpdate().then(
          () => {
            this.$emit('updated')
          }
        ).catch(
          () => {
            // clone data item detaching it from store
            this.item = this.item
          }
        )
      },
      create () {
        this.formMxCreate().then(
          () => {
            this.$emit('created')
          }
        ).catch(
          () => {}
        )
      },
      delete () {
        this.formMxDelete().then(
          () => {
            this.$emit('deleted')
          }
        ).catch(
          () => {}
        )
      }
    },
    watch: {
      id (value) {
        if (!this.item || this.item.id !== value) {
          this.formMxRead()
        }
      }
    },
    created () {
      if (this.id__) {
        this.formMxRead()
      }
    }
  }
</script>