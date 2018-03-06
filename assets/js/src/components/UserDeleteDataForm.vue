<template>
    <user-read-fields-item :item="item" />
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import UserReadFieldsItem from './UserReadFieldsItem'

  export default {
    name: 'user-delete-data-form',
    extends: BaseDataForm,
    components: {
      UserReadFieldsItem
    },
    data () {
      return {
        prefix_: 'admin',
        table_: 'user'
      }
    }
  }
</script>