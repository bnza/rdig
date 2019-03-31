<template>
    <phase-read-fields-item :item="item" />
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import PhaseReadFieldsItem from './PhaseReadFieldsItem'

  export default {
    name: "campaign-delete-data-form",
    extends: BaseDataForm,
    components: {
      PhaseReadFieldsItem
    }
  }
</script>
