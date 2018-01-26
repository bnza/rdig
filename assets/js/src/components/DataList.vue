<template>
    <component v-bind:is="tableComponent"></component>
</template>

<script>
  export default {
    props: ['tableName'],
    components: {
      DataTableSite: () => import(
        /* webpackChunkName: "DataTableSite" */
        './DataTableSite'
        )
    },
    computed: {
      tableComponent: function () {
        let ucfirst = (string) =>
        {
          return string.charAt(0).toUpperCase() + string.slice(1);
        }
        return "DataTable" + ucfirst(this.tableName)
      }
    },
    name: "DataList"
  }
</script>

<style scoped>

</style>