<template>
    <div
        v-bind:style="{ maxWidth: $_RSTableMx_maxWidth}"
    >
        <component
            ref="toolbar"
            v-bind:is="toolbarComponentName"
            v-on="$listeners"
            v-on:forward="forwardEventToForm"
        />
        <component
            ref="dataForm"
            :id__="id__"
            :is="dataFormComponentName"
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
    props: {
      id__: {
        type: [Number, String],
        validator (value) {
          return /^\d*,?\d*$/.test(value)
        }
      },
      table__: {
        type: String,
        required: true
      }
    },
    computed: {
      dataFormComponent: function () {
        return this.$refs.dataForm
      },
      dataFormComponentName: function () {
        return `${pascalize(this.table__)}ReadDataForm`
      },
      toolbarComponentName: function () {
        let component = 'BaseDataItemToolbar'
        if (this.rsTableMxTable.hasOwnProperty('item')) {
          component = this.rsTableMxTable.item.toolbar || component
        }
        return component
      }
    },
    methods: {
      forwardEventToForm () {
        let dataForm = this.$refs.dataForm
        let args = [...arguments]
        if (dataForm) {
          dataForm[args.splice(0,1)](args || undefined)
        }
      }
    }
  }
</script>