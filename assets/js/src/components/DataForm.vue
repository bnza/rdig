<template>
    <div>
        <component
            ref="form"
            v-bind:is="actionComponent"
            v-bind:id="id"
            v-bind:tableName="tableName"
            v-bind:action="action"
            v-on:showDeleteModal="showDeleteModal"
            v-on:hideDeleteModal="hideDeleteModal"
        />
        <DataFormDeleteModal
            v-if="isDeleteModal"
            v-bind:tableName="tableName"
            v-on:cancel="hideDeleteModal"
            v-on:deleteEntity="deleteEntity"
        />
    </div>
</template>

<script>

  export default {
    props: ['tableName', 'action', 'id'],
    data: function () {
      return {
        currentAction: null
      }
    },
    created () {
        this.currentAction = this.action
    },
    components: {
      DataFormSiteCreate: () => import(
        /* webpackChunkName: "DataFormSiteCreate" */
        './DataFormSiteCreate'
        ),
      DataFormSiteRead: () => import(
        /* webpackChunkName: "DataFormSiteRead" */
        './DataFormSiteRead'
        ),
      DataFormSiteUpdate: () => import(
        /* webpackChunkName: "DataFormSiteUpdate" */
        './DataFormSiteUpdate'
        ),
      DataFormDeleteModal: () => import(
        /* webpackChunkName: "DataFormDeleteModal" */
        './DataFormDeleteModal'
        ),
    },
    computed: {
      actionComponent: function () {
        let ucfirst = (string) =>
        {
          return string.charAt(0).toUpperCase() + string.slice(1);
        }
        // Delete action will render the read form
        let action = this.action === 'delete' ? 'read' : this.action

        return "DataForm" + ucfirst(this.tableName) + ucfirst(action)
      },
      isDeleteModal: function () {
        return this.currentAction === 'delete'
      }
    },
    methods: {
      showDeleteModal: function () {
        this.currentAction = 'delete'
      },
      hideDeleteModal: function () {
        this.currentAction = 'read'
      },
      deleteEntity: function () {
        let form = this.$refs.form
        form.method = 'delete'
        form.submitRequest()
      },
    },
    name: "DataForm"
  }
</script>

<style scoped>

</style>