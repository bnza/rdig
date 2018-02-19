<template>
    <article>
        <data-form-delete-modal
            v-on:delete="deleteItem"
            v-on:close="isDeleteModalActive=false"
            v-bind:table="$_route.table"
            v-bind:active="isDeleteModalActive"
            v-bind:isRequestPending="isRequestPending"
        />
        <data-form-user-allowed-sites-add-modal
            v-bind:userId="userId"
            v-on:close="isAddModalActive=false"
            v-on:grant="grantPrivileges"
            v-bind:active="isAddModalActive"
            v-bind:isRequestPending="isRequestPending"
        />
        <base-table ref="table"
                    v-bind:tableConfigObject="tableConfigObject"
                    v-bind="$props"
                    v-on:openDeleteModal="openDeleteModal"
        />
    </article>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import RequestHelperMixin from '../mixins/RequestHelperMixin'
  import BaseTable from './BaseTable'
  import DataFormDeleteModal from './DataFormDeleteModal'
  import DataFormUserAllowedSitesAddModal from './DataFormUserAllowedSitesAddModal'
  import {props} from "../mixins/DataTableMixin";

  export default {
    name: "data-table-user-allowed-sites",
    components:{
      BaseTable,
      DataFormDeleteModal,
      PathHelperMixin,
      DataFormUserAllowedSitesAddModal
    },
    props: props,
    mixins: [
      RequestHelperMixin,
      PathHelperMixin
    ],
    data: function () {
      return {
        //isRequestPending <- RequestHelperMixin
        isDeleteModalActive: false,
        isAddModalActive: false,
        currentId: '',
        tableConfigObject: {
          columns: {
            id: {
              body: {
                component: 'OpenDeleteModalTableDataCell'
              }
            },
            code: {},
            name: {}
          }
        }
      }
    },
    computed: {
      ids: function () {
        return this.currentId.split(',')
      },
      userId: function () {
        return this.parent.id * 1
      },
      siteId: function () {
        return this.ids[1]
      }
    },
    created: function() {
      if (this.$route.meta.hasOwnProperty('openAddModal')) {
        this.isAddModalActive = value.openAddModal
      }
    },
    methods: {
      openDeleteModal: function (id) {
        this.currentId = id
        this.isDeleteModalActive = true
      },
      deleteItem: function () {
        let vm = this
        const config = {
          method: 'delete',
          url: `admin/user/${this.userId}/user-allowed-sites/${this.siteId}`
        }
        this.performRequest(config)
          .then(
            function (response) {
              vm.$refs.table.$_DataTableMixin_fetchData()
              vm.isDeleteModalActive = false
            }
          )
      },
      grantPrivileges: function (siteId) {
        let vm = this
        const config = {
          method: 'post',
          url: `admin/user/${this.$_route.id}/user-allowed-sites`,
          data: {
            siteId: siteId
          }
        }
        this.performRequest(config)
          .then(
            function (response) {
              vm.$refs.table.$_DataTableMixin_fetchData()
              vm.isAddModalActive = false
            }
          )
      }
    }
  }
</script>