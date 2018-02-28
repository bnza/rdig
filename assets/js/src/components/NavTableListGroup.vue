<template>
        <v-list-group no-action>
            <v-list-tile slot="activator">
                <v-list-tile-action>
                    <v-icon>view_comfy</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Data tables</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
                v-for="(table, key) in tables"
                v-if="!table.group || table.group === 'data'"
                :key="key"
                @click="routingMxOpenTable(key)"
            >
                <v-list-tile-content>
                    <v-list-tile-title>{{table.label}}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list-group>
</template>

<script>
  import RSTableMx from '../mixins/RSTableMx'
  import {routingMxOpenTable} from '../mixins/RoutingMx'

  export default {
    name: 'nav-table-list-group',
    mixins: [
      RSTableMx
    ],
    computed: {
      tables () {
        return this.rsTableMxTables
      }
    },
    methods: {
      routingMxOpenTable
    }
  }
</script>