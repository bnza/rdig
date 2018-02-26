<template>
    <v-data-table
        :headers="$_RSTableMx_headers"
        :items="items"
        hide-actions
    >
        <template slot="items" slot-scope="props">
            <slot v-bind="props"/>
        </template>
    </v-data-table>
</template>

<script>
  import RSTableMx from '../mixins/RSTableMx'

  export default {
    name: 'base-data-table',
    mixins: [
      RSTableMx
    ],
    props: {
      items: {
        type: Array,
        default:[]
      }
    }
  }
</script>
