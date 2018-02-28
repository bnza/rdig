<script>
  import PathMx from '../mixins/PathMx'
  import UuidMx from '../mixins/UuidMx'
  import FormMx from '../mixins/FormMx'
  export default {
    name: 'base-data-form',
    mixins: [
      PathMx,
      UuidMx,
      FormMx
    ],
    methods: {
      update () {
        this.formMxUpdate().then(
          (response) => {
            this.$emit('updated')
          }
        )
      },
      create () {
        this.formMxCreate().then(
          (response) => {
            this.$emit('created')
          }
        )
      },
      delete () {
        this.formMxDelete().then(
          (response) => {
            this.$emit('deleted')
          }
        )
      }
    },
    watch: {
      pathMxItemIdC (value) {
        if (!this.formMxItemD || this.formMxItemD.id !== value) {
          this.formMxRead()
        }
      },
      formMxItemP (value) {
        if (value) {
          this.formMxItemD = value
          if (value.id) {
            this.pathMxItemIdD = value.id
          }
        }
      }
    }
  }
</script>