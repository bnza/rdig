<template>
    <site-read-fields-item :item="item" />
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import SiteReadFieldsItem from './SiteReadFieldsItem'

  export default {
    name: "site-delete-data-form",
    extends: BaseDataForm,
    components: {
      SiteReadFieldsItem
    }
  }
</script>