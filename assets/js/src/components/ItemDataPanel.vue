<template>
    <article>
        <component
            ref="toolbar"
            :is="toolbarComponentName"
            :dCuid="dCuid"
            :item="item"
            v-bind="$props"
            v-on="$listeners"
            @forward="forwardEventToDataComponent"
        />
        <component
            ref="dataComponent"
            v-bind="$props"
            :is="dataComponentName"
            @created="setDataComponentUuid"
            @ready="setItem"
            v-on="$listeners"
        />
    </article>
</template>

<script>
  import BaseDataPanel from './BaseDataPanel'
  import RSTableMx from '../mixins/RSTableMx'
  import UuidMx from '../mixins/UuidMx'
  import {pascalize} from '../util'

  export default {
    name: 'item-data-panel',
    extends: BaseDataPanel,
    data () {
      return {
        item: null
      }
    },
    components: {
      ItemDataToolbar: () => import(
        /* webpackChunkName: "ItemDataToolbar" */
        './ItemDataToolbar'
        ),
      AreaReadDataForm: () => import(
        /* webpackChunkName: "AreaReadDataForm" */
        './AreaReadDataForm'
        ),
      BucketItemDataToolbar: () => import(
        /* webpackChunkName: "BucketItemDataToolbar" */
        './BucketItemDataToolbar'
        ),
      BucketReadDataForm: () => import(
        /* webpackChunkName: "BucketReadDataForm" */
        './BucketReadDataForm'
        ),
      CampaignReadDataForm: () => import(
        /* webpackChunkName: "CampaignReadDataForm" */
        './CampaignReadDataForm'
        ),
      PhaseReadDataForm: () => import(
        /* webpackChunkName: "PhaseReadDataForm" */
        './PhaseReadDataForm'
        ),
      ContextReadDataForm: () => import(
        /* webpackChunkName: "ContextReadDataForm" */
        './ContextReadDataForm'
        ),
      ObjectReadDataForm: () => import(
        /* webpackChunkName: "ObjectReadDataForm" */
        './ObjectReadDataForm'
        ),
      PotteryReadDataForm: () => import(
        /* webpackChunkName: "PotteryReadDataForm" */
        './PotteryReadDataForm'
        ),
      SiteItemDataToolbar: () => import(
        /* webpackChunkName: "SiteItemDataToolbar" */
        './SiteItemDataToolbar'
        ),
      SampleReadDataForm: () => import(
        /* webpackChunkName: "SampleReadDataForm" */
        './SampleReadDataForm'
        ),
      SiteReadDataForm: () => import(
        /* webpackChunkName: "SiteReadDataForm" */
        './SiteReadDataForm'
        ),
      UserReadDataForm: () => import(
        /* webpackChunkName: "UserReadDataForm" */
        './UserReadDataForm'
        ),
      UserItemDataToolbar: () => import(
        /* webpackChunkName: "UserDataItemToolbar" */
        './UserItemDataToolbar'
        )
    },
    mixins: [
      RSTableMx,
      UuidMx
    ],
    computed: {
      dataComponentName: function () {
        return `${pascalize(this.table__)}ReadDataForm`
      },
      toolbarComponentName: function () {
        let component = 'ItemDataToolbar'
        if (this.rsTableMxTable.hasOwnProperty('item')) {
          component = this.rsTableMxTable.item.toolbar || component
        }
        return component
      }
    },
    methods: {
      setItem (a,b) {
        this.item = a
      }
    }
  }
</script>
