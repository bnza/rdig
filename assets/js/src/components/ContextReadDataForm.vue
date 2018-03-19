<template>
    <data-item-card :item="item">
        <context-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import ContextReadFieldsItem from './ContextReadFieldsItem'

  export default {
    name: "context-read-data-form",
    extends: BaseDataForm,
    components: {
      DataItemCard,
      ContextReadFieldsItem,
    }
  }
</script>