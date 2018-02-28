<!--
    <div>
        <*-data-list-toolbar> **store.state.tables.*.list.toolbar** e.g. UserDataListToolbar
        <*-data-table> **route.params.table**                e.g. UserDataTable
    </div>
-->

<template>
    <div>
        <data-list
            :uuidMxRegister="true"
        />
    </div>
</template>

<script>
  import DataList from './DataList'
  import UuidMx from '../mixins/UuidMx'

  export default {
    name: 'the-data-list',
    components: {
      DataList
    },
    mixins: [
      UuidMx
    ]
  }
</script>