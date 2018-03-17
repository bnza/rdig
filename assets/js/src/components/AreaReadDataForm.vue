<template>
    <data-item-card :item="item">
        <area-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import AreaReadFieldsItem from './AreaReadFieldsItem'

  export default {
    name: "area-read-data-form",
    extends: BaseDataForm,
    components: {
      DataItemCard,
      AreaReadFieldsItem,
    }
  }
</script>