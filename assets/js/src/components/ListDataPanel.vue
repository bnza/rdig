<!--
    <div>
        <*-data-list-toolbar> **store.state.tables.*.list.toolbar** e.g. UserDataListToolbar
        <*-data-table> **route.params.table**                e.g. UserDataTable
    </div>
-->

<template>
    <article>
        <component
            :flat="true"
            ref="toolbar"
            :is="toolbarComponentName"
            @forward="forwardEventToDataComponent"
            v-on="$listeners"
            v-bind="$props"
            :dCuid="dCuid"
            @openModal="openModal"
        />
        <component
            ref="dataComponent"
            v-bind:is="dataComponentName"
            :uuidMxRegister="true"
            v-on="$listeners"
            v-bind="$props"
            @created="setDataListComponentUuid"
        />
    </article>
</template>

<script>
  import BaseDataPanel from './BaseDataPanel'
  import PathMx from '../mixins/PathMx'
  import RSTableMx from '../mixins/RSTableMx'
  import UuidMx from '../mixins/UuidMx'
  import {pascalize} from '../util'

  export default {
    name: 'list-data-panel',
    extends: BaseDataPanel,
    components: {
      AreaDataTable: () => import(
        /* webpackChunkName: "AreaDataTable" */
        './AreaDataTable'
        ),
      BucketDataTable: () => import(
        /* webpackChunkName: "BucketDataTable" */
        './BucketDataTable'
        ),
      CampaignDataTable: () => import(
        /* webpackChunkName: "CampaignDataTable" */
        './CampaignDataTable'
        ),
      ContextDataTable: () => import(
        /* webpackChunkName: "ContextDataTable" */
        './ContextDataTable'
        ),
      FindingDataTable: () => import(
        /* webpackChunkName: "FindingDataTable" */
        './FindingDataTable'
        ),
      FindingListDataToolbar: () => import(
        /* webpackChunkName: "FindingDataToolbar" */
        './FindingListDataToolbar'
        ),
      ListDataToolbar: () => import(
        /* webpackChunkName: "ListBaseDataToolbar" */
        './ListDataToolbar'
        ),
      ObjectDataTable: () => import(
        /* webpackChunkName: "ObjectDataTable" */
        './ObjectDataTable'
        ),
      PotteryDataTable: () => import(
        /* webpackChunkName: "PotteryDataTable" */
        './PotteryDataTable'
        ),
      SampleDataTable: () => import(
        /* webpackChunkName: "SampleDataTable" */
        './SampleDataTable'
        ),
      SiteDataTable: () => import(
        /* webpackChunkName: "SiteDataTable" */
        './SiteDataTable'
        ),
      TheSearchModal: () => import(
        /* webpackChunkName: "TheSearchModal" */
        './TheSearchModal'
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
    data () {
      return {
        modalComponentName: ''
      }
    },
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
      openModal (name, unique) {
        let component = `${pascalize(this.table)}${pascalize(name)}DataTable`
        if (unique) {
          component = `The${pascalize(name)}Modal`
        }
        this.modalComponentName = component
      },
      closeModal () {
        this.modalComponentName = ''
      },
      setDataListComponentUuid(uuid) {
        this.setDataComponentUuid(uuid)
        this.$listeners.listDataComponentCreated(uuid)
        //this.$emit('listDataComponentCreated', uuid)
      }
    }
  }
</script>

<style scoped>
    h2 {
        margin-top: 3rem;
    }
</style>