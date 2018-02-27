<template>
    <data-item>
        <site-read-fields-item :item="item" />
    </data-item>
</template>

<script>
  import PathMx from '../mixins/PathMx'
  import UuidMx from '../mixins/UuidMx'
  import FormMx from '../mixins/FormMx'
  import DataItem from './DataItem'
  import SiteReadFieldsItem from './SiteReadFieldsItem'

  export default {
    name: "site-read-data-item",
    components: {
      DataItem,
      SiteReadFieldsItem
    },
    mixins: [
      PathMx,
      UuidMx,
      FormMx
    ],
    data () {
      return {
        item: {}
      }
    }
  }
</script>

<style scoped>

</style>