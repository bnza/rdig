<template>
    <v-list-group no-action>
        <v-list-tile slot="activator">
            <v-list-tile-action>
                <v-icon>verified_user</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Admin</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile
            v-for="(table, key) in tables"
            v-if="!table.hidden && table.group === 'admin'"
            :key="key"
            @click="routingMxOpenTable(key, 'admin_table_read')"
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
    name: 'nav-admin-list-group',
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