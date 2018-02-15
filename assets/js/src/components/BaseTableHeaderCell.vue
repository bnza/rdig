<template>
    <th>
        {{label}}
    </th>
</template>

<script>
  export default {
    props: {
      uuid: {
        type: Number,
        required: true
      },
      columnKey: {
        required: true,
        type: String
      }
    },
    name: "base-table-header-cell",
    computed: {
      field: function () {
        return this.$store.getters['components/tables/field'](this.uuid, this.columnKey)
      },
      label: function () {
        return this.$store.getters['components/tables/label'](this.uuid, this.columnKey)
      }
    }
  }
</script>

<style scoped>

</style>