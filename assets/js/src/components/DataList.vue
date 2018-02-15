<template>
    <div>
        <h2 v-if="parent" class="is-size-3">{{$_route.table}}</h2>
        <component
            v-bind:is="tableComponent"
            v-bind:parent="parent"
            v-bind:route="route"
        />
    </div>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import {pascalize} from '../util'

  export default {
    name: "data-list",
    components: {
      DataTableSite: () => import(
        /* webpackChunkName: "DataTableSite" */
        './DataTableSite'
        ),
      DataTableUser: () => import(
        /* webpackChunkName: "DataTableUser" */
        './DataTableUser'
        ),
      DataTableUserAllowedSites: () => import(
        /* webpackChunkName: "DataTableUserAllowedSites" */
        './DataTableUserAllowedSites'
        ),
    },
    mixins: [
      PathHelperMixin
    ],
    props: ['parent'],
    computed: {
      tableComponent: function () {
        return "DataTable" + pascalize(this.$_route.table)
      }
    },

  }
</script>

<style scoped>
    h2 {
        margin-top: 3rem;
    }
</style>