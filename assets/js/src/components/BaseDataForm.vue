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
      item__: {
        type: Object,
        validator (value) {
          return typeof value === 'undefined' || value.hasOwnProperty('id')
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
        return this.id__ || this.item.id
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
      create () {
        this.formMxCreate().then(
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
      delete () {
        this.formMxDelete().then(
          () => {
            this.$emit('sync')
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
      if (this.item__) {
        this.item_ = this.item__
      } else if (this.id__) {
        this.formMxRead()
      }
    }
  }
</script>