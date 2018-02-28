<template>
    <div
        v-bind:style="{ maxWidth: $_RSTableMx_maxWidth}"
    >
<!--        <component
            ref="toolbar"
            v-bind:is="toolbarComponent"
            v-on="$listeners"
        />-->
        <component
            v-bind:is="itemReadComponent"
            v-on="$listeners"
        />
    </div>
</template>

<script>
  import RSTableMx from '../mixins/RSTableMx'
  import UuidMx from '../mixins/UuidMx'
  import {pascalize} from '../util'

  export default {
    name: 'data-item',
    components: {
      BaseDataItemToolbar: () => import(
        /* webpackChunkName: "BaseDataItemToolbar" */
        './BaseDataItemToolbar'
        ),
      SiteReadDataForm: () => import(
        /* webpackChunkName: "SiteReadDataForm" */
        './SiteReadDataForm'
        ),
      UserReadDataForm: () => import(
        /* webpackChunkName: "UserReadDataForm" */
        './UserReadDataForm'
        ),
      UserDataItemToolbar: () => import(
        /* webpackChunkName: "UserDataItemToolbar" */
        './UserDataItemToolbar'
        )
    },
    mixins: [
      RSTableMx,
      UuidMx
    ],
    computed: {
      itemReadComponent: function () {
        return `${pascalize(this.$route.params.table)}ReadDataForm`
      },
      toolbarComponent: function () {
        let component = 'BaseDataItemToolbar'
        if (this.rsTableMxTable.hasOwnProperty('item')) {
          component = this.rsTableMxTable.item.toolbar || component
        }
        return component
      }
    },
  }
</script>