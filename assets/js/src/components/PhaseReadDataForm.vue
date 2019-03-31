<template>
    <data-item-card :item="item">
        <phase-read-fields-item :item="item" />
    </data-item-card>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import PhaseReadFieldsItem from './PhaseReadFieldsItem'

  export default {
    name: "phase-read-data-form",
    extends: BaseDataForm,
    components: {
      DataItemCard,
      PhaseReadFieldsItem,
    }
  }
</script>
