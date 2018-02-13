<script>
  import DataFormSiteEdit from './DataFormSiteEdit'

  export default {
    name: "DataFormSiteUpdate",
    extends: DataFormSiteEdit,
    created () {
        this.readData()
    },
  }
</script>