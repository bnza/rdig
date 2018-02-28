<template>
    <data-item-card :item="item">
        <site-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import SiteReadFieldsItem from './SiteReadFieldsItem'

  export default {
    name: "site-read-data-form",
    extends: BaseDataForm,
    components: {
      DataItemCard,
      SiteReadFieldsItem,
    }
  }
</script>