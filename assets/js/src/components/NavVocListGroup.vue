<template>
        <v-list-group no-action>
            <v-list-tile slot="activator">
                <v-list-tile-action>
                    <v-icon>import_contacts</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Vocabularies tables</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
                @click="$router.push('/voc/o/type/read')"
            >
                <v-list-tile-content>
                    <v-list-tile-title>Type (object)</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list-group>
</template>

<script>
  import RSTableMx from '../mixins/RSTableMx'
  import {routingMxListPath} from '../mixins/RoutingMx'

  export default {
    name: 'nav-voc-list-group',
    mixins: [
      RSTableMx
    ],
    computed: {
      tables () {
        return this.rsTableMxTables
      }
    },
    methods: {
      goToList (table, prefix) {
        this.$router.push(routingMxListPath(table, prefix))
      }
    }
  }
</script>