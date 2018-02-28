<template>
    <data-item-card :item="item">
        <site-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import PathMx from '../mixins/PathMx'
  import UuidMx from '../mixins/UuidMx'
  import FormMx from '../mixins/FormMx'
  import DataItemCard from './DataItemCard'
  import SiteReadFieldsItem from './SiteReadFieldsItem'

  export default {
    name: "site-read-data-item",
    components: {
      DataItemCard,
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
    },
    created () {
      this.formMxRead()
    }
  }
</script>

<style scoped>

</style>