<template>
    <data-item-card :item="item">
        <user-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import UserReadFieldsItem from './UserReadFieldsItem'

  export default {
    name: 'user-read-data-item',
    extends: BaseDataForm,
    components: {
      DataItemCard,
      UserReadFieldsItem
    },
    data () {
      return {
        prefix_: 'admin'
      }
    }
  }
</script>