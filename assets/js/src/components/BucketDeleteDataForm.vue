<template>
    <bucket-read-fields-item :item="item" />
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import BucketReadFieldsItem from './BucketReadFieldsItem'

  export default {
    name: "bucket-delete-data-form",
    extends: BaseDataForm,
    components: {
      BucketReadFieldsItem
    }
  }
</script>