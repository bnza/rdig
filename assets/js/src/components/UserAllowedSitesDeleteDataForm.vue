<template>
    <site-read-fields-item :item="item" />
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import SiteReadFieldsItem from './SiteReadFieldsItem'

  export default {
    name: 'user-allowed-sites-delete-data-form',
    extends: BaseDataForm,
    components: {
      SiteReadFieldsItem
    },
    data () {
      return {
        prefix_: 'admin',
        table_: 'user-allowed-sites'
      }
    }
  }
</script>
