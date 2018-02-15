<template>
    <tr>
        <component
            v-for="(value, key) in $store.getters['components/tables/columns'](uuid)"
            v-if="$store.getters['components/tables/isColumnVisible'](uuid, key)"
            v-bind:is="getDataCellComponent(key)"
            v-bind:uuid="uuid"
            v-bind:key="`r-${index}-${key}`"
            v-bind:value="rowData[key]">
        </component>
    </tr>
</template>

<script>
  export default {
    name: "base-table-row",
    components: {
      BaseTableDataCell: () => import(
        /* webpackChunkName: "BaseTableDataCell" */
        './BaseTableDataCell'
        ),
      ShowTableDataCell: () => import(
        /* webpackChunkName: "ShowTableDataCell" */
        './ShowTableDataCell'
        ),
    },
    props: {
      uuid: {
        type: Number,
        required: true
      },
      /**
       * The row index used for key
       */
      index: {
        type: Number,
        required: true
      },
      rowData: {
        type: Object,
        required: false,
        default: function () {
          return {}
        }
      },
    },
    methods: {
      getDataCellComponent: function (key) {
        return this.$store.getters['components/tables/dataCellComponent'](this.uuid, key)
      }
    }
  }
</script>

<style scoped>

</style>