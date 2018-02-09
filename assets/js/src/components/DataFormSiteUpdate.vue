<template>
    <DataFormSiteEdit
        method="put"
        v-bind:id="id"
        v-bind:routePrefix="routePrefix"
        v-bind:tableName="tableName"
        v-bind:action="action"
    />
</template>

<script>
  import DataFormSiteEdit from './DataFormSiteEdit'

  export default {
    props: ['routePrefix','tableName', 'id', 'action'],
    components: {
      DataFormSiteEdit
    },
    name: "DataFormSiteUpdate"
  }
</script>

<style scoped>

</style>