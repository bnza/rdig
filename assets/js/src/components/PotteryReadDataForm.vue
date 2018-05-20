<template>
    <data-item-card :item="item">
        <pottery-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import PotteryReadFieldsItem from './PotteryReadFieldsItem'

  export default {
    name: "pottery-read-data-form",
    extends: BaseDataForm,
    components: {
      DataItemCard,
      PotteryReadFieldsItem,
    }
  }
</script>