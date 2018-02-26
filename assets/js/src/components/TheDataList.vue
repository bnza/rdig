<template>
    <div
        v-bind:style="{ maxWidth: $_RSTableMx_maxWidth}"
    >
        <v-toolbar
            color="indigo darken-4"
            dark
        >
            <v-toolbar-side-icon/>
            <v-toolbar-title>
                {{this.$_RSTableMx_table.label}}
            </v-toolbar-title>
            <v-spacer/>
            <v-btn icon>
                <v-icon>add</v-icon>
            </v-btn>
            <v-btn icon>
                <v-icon>search</v-icon>
            </v-btn>
        </v-toolbar>
        <component
            v-bind:is="tableComponent"
        />
    </div>
</template>

<script>
  import PathMx from '../mixins/PathMx'
  import RSTableMx from '../mixins/RSTableMx'
  import {pascalize} from '../util'

  export default {
    name: "the-data-list",
    components: {
      SiteDataTable: () => import(
        /* webpackChunkName: "SiteDataTable" */
        './SiteDataTable'
        )
    },
    mixins: [
      RSTableMx,
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