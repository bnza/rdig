<template>
    <pottery-read-fields-item :item="item" />
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import PotteryReadFieldsItem from './PotteryReadFieldsItem'

  export default {
    name: "pottery-delete-data-form",
    extends: BaseDataForm,
    components: {
      PotteryReadFieldsItem
    }
  }
</script>