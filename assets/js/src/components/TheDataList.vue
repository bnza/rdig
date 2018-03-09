<!--
    <div>
        <*-data-list-toolbar> **store.state.tables.*.list.toolbar** e.g. UserDataListToolbar
        <*-data-table> **route.params.table**                e.g. UserDataTable
    </div>
-->

<template>
    <section>
        <list-data-panel
            :parent__="parent"
            :prefix__="$route.params.prefix"
            :table__="$route.params.table"
            :id__="$route.params.id"
            :uuidMxRegister="true"
            v-on="$listeners"
        />
    </section>
</template>

<script>
  import ListDataPanel from './ListDataPanel'
  import UuidMx from '../mixins/UuidMx'

  export default {
    name: 'the-data-list',
    components: {
      ListDataPanel
    },
    mixins: [
      UuidMx
    ],
    computed: {
      parent () {
        if (this.$route.params.childTable) {
          return {
            table: this.$route.params.table,
            id:  this.$route.params.id
          }
        }
      }
    }
  }
</script>