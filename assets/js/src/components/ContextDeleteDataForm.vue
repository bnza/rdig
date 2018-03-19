<template>
    <context-read-fields-item :item="item" />
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import ContextReadFieldsItem from './ContextReadFieldsItem'

  export default {
    name: "context-delete-data-form",
    extends: BaseDataForm,
    components: {
      ContextReadFieldsItem
    }
  }
</script>