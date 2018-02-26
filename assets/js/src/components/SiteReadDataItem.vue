<template>
    <data-item>
        <site-read-fields-item :item="item" />
    </data-item>
</template>

<script>
  import PathMx from '../mixins/PathMx'
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