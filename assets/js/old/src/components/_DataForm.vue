<template>
    <div>
        <component
            ref="form"
            v-bind:is="actionComponent"
            v-on:showDeleteModal="showDeleteModal"
            v-on:hideDeleteModal="hideDeleteModal"
        />
        <DataFormDeleteModal
            v-if="isDeleteModal"
            v-on:cancel="hideDeleteModal"
            v-on:deleteEntity="deleteEntity"
        />
    </div>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'
  export default {
    name: 'data-form',
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
      DataFormUserCreate: () => import(
        /* webpackChunkName: "DataFormUserCreate" */
        './DataFormUserCreate'
        ),
      DataFormUserChangePassword: () => import(
        /* webpackChunkName: "DataFormUserChangePassword" */
        './DataFormUserChangePassword'
        ),
      DataFormUserRead: () => import(
        /* webpackChunkName: "DataFormUserRead" */
        './DataFormUserRead'
        ),
      DataFormDeleteModal: () => import(
        /* webpackChunkName: "DataFormDeleteModal" */
        './DataFormDeleteModal'
        ),
    },
    mixins: [
      PathHelperMixin
    ],
    data: function () {
      return {
        currentAction: null
      }
    },
    computed: {
      actionComponent: function () {
        let ucfirst = (string) =>
        {
          let pieces = string.split('-')
          return pieces.map(function (piece) {
            return piece.charAt(0).toUpperCase() + piece.slice(1);
          }).join('')
        }
        // Delete action will render the read form
        let action = this.$_route.action === 'delete' ? 'read' : this.$_route.action

        return "DataForm" + ucfirst(this.$_route.table) + ucfirst(action)
      },
      isDeleteModal: function () {
        return this.currentAction === 'delete'
      }
    },
    created () {
      this.currentAction = this.action
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
    }
  }
</script>