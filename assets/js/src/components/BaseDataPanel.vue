<script>
  import DataMx from '../mixins/DataMx'
  export default {
    name: 'base-data-panel',
    mixins: [
      DataMx
    ],
    data () {
      return {
        dCuid: ''
      }
    },
/*    props: {
      parent__: {
        type: Object
      },
      prefix__: {
        type: String,
        default: 'data'
      },
      id__: {
        type: [Number, String],
        validator (value) {
          return /^\d*,?\d*$/.test(value)
        }
      },
      table__: {
        type: String,
        required: true
      }
    },*/
    computed: {
      dataComponent () {
        return this.$refs.dataComponent
      }
    },
    methods: {
      setDataComponentUuid (uuid) {
        this.dCuid = uuid
      },
      forwardEventToDataComponent () {
        if (this.dataComponent) {
          let args = [...arguments]
          this.dataComponent[args.splice(0,1)](args || undefined)
        }
      }
    }
  }
</script>

<style scoped>

</style>