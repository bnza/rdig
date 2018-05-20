<template>
    <data-item-card :item="item">
        <object-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import ObjectReadFieldsItem from './ObjectReadFieldsItem'

  export default {
    name: "object-read-data-form",
    extends: BaseDataForm,
    components: {
      DataItemCard,
      ObjectReadFieldsItem,
    }
  }
</script>