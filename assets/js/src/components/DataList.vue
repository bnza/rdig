<template>
    <div>
        <h2 v-if="parent" class="is-size-3">{{title}}</h2>
        <component
            v-bind:is="tableComponent"
            v-bind:parent="parent"
            v-bind:route="route"
        />
    </div>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import {pascalize, camelize, decamelize} from '../util'

  export default {
    name: "DataList",
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
      },
      title: function () {
        return decamelize(camelize(this.$_route.table), ' ')
      }
    }

  }
</script>

<style scoped>
    h2 {
        margin-top: 3rem;
    }
</style>