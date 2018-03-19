<template>
    <article>
        <component
            ref="toolbar"
            :is="toolbarComponentName"
            :dCuid="dCuid"
            v-bind="$props"
            v-on="$listeners"
            @forward="forwardEventToDataComponent"
        />
        <component
            ref="dataComponent"
            v-bind="$props"
            :is="dataComponentName"
            @created="setDataComponentUuid"
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
    components: {
      ItemDataToolbar: () => import(
        /* webpackChunkName: "ItemDataToolbar" */
        './ItemDataToolbar'
        ),
      AreaReadDataForm: () => import(
        /* webpackChunkName: "AreaReadDataForm" */
        './AreaReadDataForm'
        ),
      ContextReadDataForm: () => import(
        /* webpackChunkName: "ContextReadDataForm" */
        './ContextReadDataForm'
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
    }
  }
</script>