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
                v-for="key in sortedVocabularyKey"
                :key="key"
                @click="$router.push(`/voc/${vocabularies[key].type}/${vocabularies[key].name}/read`)"
            >
                <v-list-tile-content>
                    <v-list-tile-title>{{vocabularies[key].label}}</v-list-tile-title>
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
      },
      vocabularies () {
        return this.$store.state.vocabularies;
      },
      sortedVocabularyKey () {
        let vocabularies = this.$store.state.vocabularies
        const keys = Object.keys(vocabularies)
        return keys.sort(function(a, b) {
            return vocabularies[a].label.localeCompare(vocabularies[b].label);
          }
        )
      }
    },
    methods: {
      goToList (table, prefix) {
        this.$router.push(routingMxListPath(table, prefix))
      }
    }
  }
</script>