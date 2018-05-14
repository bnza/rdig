<template>
    <data-item-card :item="item">
        <sample-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import SampleReadFieldsItem from './SampleReadFieldsItem'

  export default {
    name: "bucket-read-data-form",
    extends: BaseDataForm,
    components: {
      DataItemCard,
      SampleReadFieldsItem,
    }
  }
</script>