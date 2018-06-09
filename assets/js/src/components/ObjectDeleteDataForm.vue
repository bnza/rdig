<template>
    <object-read-fields-item :item="item" />
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import ObjectReadFieldsItem from './ObjectReadFieldsItem'

  export default {
    name: "object-delete-data-form",
    extends: BaseDataForm,
    components: {
      ObjectReadFieldsItem
    }
  }
</script>