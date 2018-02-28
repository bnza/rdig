<!--
    <div>
        <*-data-list-toolbar> **store.state.tables.*.list.toolbar** e.g. UserDataListToolbar
        <*-data-table> **route.params.table**                e.g. UserDataTable
    </div>
-->

<template>
    <div
        v-bind:style="{ maxWidth: $_RSTableMx_maxWidth}"
    >
        <component
            :flat="true"
            ref="toolbar"
            v-bind:is="toolbarComponent"
            @openAddModal="openAddModal"
            v-on="$listeners"
            v-bind="$props"
        />
        <component
            ref="dataTable"
            v-bind:is="tableComponent"
            :uuidMxRegister="true"
            v-on="$listeners"
            v-bind="$props"
        />
    </div>
</template>

<script>
  import PathMx from '../mixins/PathMx'
  import RSTableMx from '../mixins/RSTableMx'
  import UuidMx from '../mixins/UuidMx'
  import {tableMxModalOpeners} from '../mixins/TableMx'
  import {pascalize} from '../util'

  export default {
    name: 'data-list',
    components: {
      BaseDataListToolbar: () => import(
        /* webpackChunkName: "BaseDataListToolbar" */
        './BaseDataListToolbar'
        ),
      SiteDataTable: () => import(
        /* webpackChunkName: "SiteDataTable" */
        './SiteDataTable'
        ),
      UserDataListToolbar: () => import(
        /* webpackChunkName: "UserDataListToolbar" */
        './UserDataListToolbar'
        ),
      UserAllowedSitesDataTable: () => import(
        /* webpackChunkName: "UserAllowedSitesDataTable" */
        './UserAllowedSitesDataTable'
        ),
      UserDataTable: () => import(
        /* webpackChunkName: "UserDataTable" */
        './UserDataTable'
        )
    },
    mixins: [
      UuidMx,
      RSTableMx,
      PathMx
    ],
    props: {
      parent__: {
        type: Object,
        validator (value) {
          return value.hasOwnProperty('table') &&  value.hasOwnProperty('id')
        }
      },
      table__: {
        type: String
      }
    },
    computed: {
      parent () {
        return this.parent__
      },
      table () {
        return this.table__
      },
      toolbarComponent: function () {
        let component = 'BaseDataListToolbar'
        if (this.rsTableMxTable.hasOwnProperty('list')) {
          component = this.rsTableMxTable.list.toolbar || component
        }
        return component
      },
      tableComponent: function () {
        return `${pascalize(this.rsTableMxTableName)}DataTable`
      }
    },
    methods: {
      ...tableMxModalOpeners,
      openAddModal () {
        this.tableMxOpenAddModal({}, this.$refs.dataTable.uuid)
      }
    }
  }
</script>

<style scoped>
    h2 {
        margin-top: 3rem;
    }
</style>