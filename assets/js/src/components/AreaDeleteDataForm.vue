<template>
    <area-read-fields-item :item="item" />
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import AreaReadFieldsItem from './AreaReadFieldsItem'

  export default {
    name: "area-delete-data-form",
    extends: BaseDataForm,
    components: {
      AreaReadFieldsItem
    }
  }
</script>