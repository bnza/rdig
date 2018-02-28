<template>
    <data-item-card :item="item">
        <user-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import PathMx from '../mixins/PathMx'
  import UuidMx from '../mixins/UuidMx'
  import FormMx from '../mixins/FormMx'
  import DataItemCard from './DataItemCard'
  import UserReadFieldsItem from './UserReadFieldsItem'

  export default {
    name: "user-read-data-form",
    components: {
      DataItemCard,
      UserReadFieldsItem
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