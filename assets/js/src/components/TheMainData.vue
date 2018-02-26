<template>
    <v-container>
        <v-layout>
            <v-flex xs10 offset-xs1>
                <h1 class="display-2">{{this.$_RSTableMx_table.label}}</h1>
                <router-view class="mt-5"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
  import FilterMx from "../mixins/FilterMx"
  import RSTableMx from '../mixins/RSTableMx'
  import BaseDataTable from './BaseDataTable'

  export default {
    name: 'the-main-data',
    components: {
      BaseDataTable
    },
    mixins: [
      FilterMx,
      RSTableMx
    ]
  }
</script>