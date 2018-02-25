<template>
    <tr>
        <component
            v-for="(config, key) in $store.getters['components/tables/columns'](uuid)"
            v-bind:is="$store.getters['components/tables/tableHeaderCellComponent'](uuid, key)"
            v-bind="$props"
            v-bind:key="key"
            v-bind:columnKey="key"
        >
        </component>
    </tr>
</template>

<script>
  export default {
    name: 'base-table-header-row',
    components: {
      SortableTableHeaderCell: () => import(
        /* webpackChunkName: "SortableTableHeaderCell" */
        './SortableTableHeaderCell'
        ),
      BaseTableHeaderCell: () => import(
        /* webpackChunkName: "BaseTableHeaderCell" */
        './BaseTableHeaderCell'
        ),
    },
    props: {
      uuid: {
        type: Number,
        required: true
      }
    },
  }
</script>

<style scoped>

</style>