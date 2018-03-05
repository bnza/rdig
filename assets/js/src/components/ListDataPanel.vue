<!--
    <div>
        <*-data-list-toolbar> **store.state.tables.*.list.toolbar** e.g. UserDataListToolbar
        <*-data-table> **route.params.table**                e.g. UserDataTable
    </div>
-->

<template>
    <article
        v-bind:style="{ maxWidth: $_RSTableMx_maxWidth}"
    >
        <component
            :flat="true"
            ref="toolbar"
            :is="toolbarComponentName"
            @forward="forwardEventToDataComponent"
            v-on="$listeners"
            v-bind="$props"
        />
        <component
            ref="dataComponent"
            v-bind:is="dataComponentName"
            :uuidMxRegister="true"
            v-on="$listeners"
            v-bind="$props"
        />
    </article>
</template>

<script>
  import BaseDataPanel from './BaseDataPanel'
  import PathMx from '../mixins/PathMx'
  import RSTableMx from '../mixins/RSTableMx'
  import UuidMx from '../mixins/UuidMx'
  import {tableMxModalOpeners} from '../mixins/TableMx'
  import {pascalize} from '../util'

  export default {
    name: 'list-data-panel',
    extends: BaseDataPanel,
    components: {
      ListDataToolbar: () => import(
        /* webpackChunkName: "ListBaseDataToolbar" */
        './ListDataToolbar'
        ),
      SiteDataTable: () => import(
        /* webpackChunkName: "SiteDataTable" */
        './SiteDataTable'
        ),
      UserListDataToolbar: () => import(
        /* webpackChunkName: "UserListDataToolbar" */
        './UserListDataToolbar'
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
    computed: {
      parent () {
        return this.parent__
      },
      table () {
        return this.table__
      },
      toolbarComponentName: function () {
        let component = 'ListDataToolbar'
        if (this.rsTableMxTable.hasOwnProperty('list')) {
          component = this.rsTableMxTable.list.toolbar || component
        }
        return component
      },
      dataComponentName: function () {
        return `${pascalize(this.rsTableMxTableName)}DataTable`
      }
    },
    methods: {
      ...tableMxModalOpeners
    }
  }
</script>

<style scoped>
    h2 {
        margin-top: 3rem;
    }
</style>