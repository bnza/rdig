<template>
    <data-item-card :item="item">
        <campaign-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import CampaignReadFieldsItem from './CampaignReadFieldsItem'

  export default {
    name: "campaign-read-data-form",
    extends: BaseDataForm,
    components: {
      DataItemCard,
      CampaignReadFieldsItem,
    }
  }
</script>