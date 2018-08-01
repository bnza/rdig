<script>
  import DataMx from '../mixins/DataMx'
  export default {
    name: 'base-data-panel',
    mixins: [
      DataMx
    ],
    data () {
      return {
        dCuid: '' //dataComponent UUID
      }
    },
    computed: {
      dataComponent () {
        return this.$refs.dataComponent
      }
    },
    methods: {
      setDataComponentUuid (uuid) {
        this.dCuid = uuid
      },
      /**
       * Forward to data component method
       * First argument must be the method name followed by the method's args
       * It's called by toolbar $emit method
       * e.g. this.$emit('forward', 'theDataComponentMethodName', 'firstArg', 'secondArg')
       */
      forwardEventToDataComponent () {
        if (this.$refs.dataComponent) {
          let args = [...arguments]
          let method = args.splice(0,1)
          this.$refs.dataComponent[method](args || undefined)
        }
      }
    }
  }
</script>

<style scoped>

</style>