<template>
    <DataFormSiteEdit
        method="post"
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
    name: "DataFormSiteCreate"
  }
</script>

<style scoped>

</style>