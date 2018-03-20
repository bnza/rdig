<template>
    <campaign-read-fields-item :item="item" />
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import CampaignReadFieldsItem from './CampaignReadFieldsItem'

  export default {
    name: "campaign-delete-data-form",
    extends: BaseDataForm,
    components: {
      CampaignReadFieldsItem
    }
  }
</script>