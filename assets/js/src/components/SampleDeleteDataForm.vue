<template>
    <sample-read-fields-item :item="item" />
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import SampleReadFieldsItem from './SampleReadFieldsItem'

  export default {
    name: "sample-delete-data-form",
    extends: BaseDataForm,
    components: {
      SampleReadFieldsItem
    }
  }
</script>