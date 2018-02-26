<template>
    <v-list-group no-action>
        <v-list-tile slot="activator">
            <v-list-tile-action>
                <v-icon>view_comfy</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Tables</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile
            v-for="(table, key) in tables"
            :key="key"
            @click="openTable(key)"
        >
            <v-list-tile-content>
                <v-list-tile-title>{{table.label}}</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
    </v-list-group>
</template>

<script>
  import RSTableMx from '../mixins/RSTableMx'

  export default {
    name: 'nav-table-list-group',
    mixins: [
      RSTableMx
    ],
    computed: {
      tables () {
        return this.$_RSTableMx_tables
      }
    },
    methods: {
      openTable (key) {
        this.$router.push({
          name: 'data_table_read',
          params: {
            prefix: 'data',
            table: key,
            action: 'read'
          }
        })
      }
    }
  }
</script>