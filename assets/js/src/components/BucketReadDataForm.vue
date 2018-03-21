<template>
    <data-item-card :item="item">
        <bucket-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import BucketReadFieldsItem from './BucketReadFieldsItem'

  export default {
    name: "bucket-read-data-form",
    extends: BaseDataForm,
    components: {
      DataItemCard,
      BucketReadFieldsItem,
    }
  }
</script>