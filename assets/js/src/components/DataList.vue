<template>
    <div>
        <component
            v-bind:is="tableComponent"
        />
    </div>
</template>

<script>
  import PathMx from '../mixins/PathMx'
  import {pascalize} from '../util'

  export default {
    name: "data-list",
    components: {
      SiteDataTable: () => import(
        /* webpackChunkName: "SiteDataTable" */
        './SiteDataTable'
        )
    },
    mixins: [
      PathMx
    ],
    computed: {
      tableComponent: function () {
        return `${pascalize(this.$route.params.table)}DataTable`
      }
    },

  }
</script>

<style scoped>
    h2 {
        margin-top: 3rem;
    }
</style>