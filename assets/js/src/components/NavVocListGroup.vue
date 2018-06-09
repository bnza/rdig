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
            <!--<v-list-tile
                @click="$router.push('/voc/f/chronology/read')"
            >
                <v-list-tile-content>
                    <v-list-tile-title>Chronology</v-list-tile-title>
                </v-lists-tile-content>
            </v-list-tile>
            <v-list-tile
                @click="$router.push('/voc/o/material-class/read')"
            >
                <v-list-tile-content>
                    <v-list-tile-title>Material class</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
                @click="$router.push('/voc/o/material-type/read')"
            >
                <v-list-tile-content>
                    <v-list-tile-title>Material type</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
                @click="$router.push('/voc/o/preservation/read')"
            >
                <v-list-tile-content>
                    <v-list-tile-title>Preservation (object)</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
                @click="$router.push('/voc/o/technique/read')"
            >
                <v-list-tile-content>
                    <v-list-tile-title>technique (object)</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
                @click="$router.push('/voc/o/type/read')"
            >
                <v-list-tile-content>
                    <v-list-tile-title>Type (object)</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
                @click="$router.push('/voc/p/type/read')"
            >
                <v-list-tile-content>
                    <v-list-tile-title>Type (pottery)</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>-->
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
    data () {
      return {
        vocabularies : {
          VocFChronology : {
            type: 'f',
            name: 'chronology',
            label: 'Chronology'
          },
          VocFColor : {
            type: 'f',
            name: 'color',
            label: 'Color (Munsell)'
          },
          VocOClass : {
            type: 'o',
            name: 'class',
            label: 'Class (object)'
          },
          VocODecoration : {
            type: 'o',
            name: 'decoration',
            label: 'Decoration (object)'
          },
          VocOMaterialClass : {
            type: 'o',
            name: 'material-class',
            label: 'Material Class'
          },
          VocOMaterialType : {
            type: 'o',
            name: 'material-type',
            label: 'Material Type'
          },
          VocOPreservation : {
            type: 'o',
            name: 'preservation',
            label: 'Preservation (object)'
          },
          VocOTechnique: {
            type: 'o',
            name: 'technique',
            label: 'Technique (object)'
          },
          VocOTType: {
            type: 'o',
            name: 'type',
            label: 'Type (object)'
          },
          VocPClass : {
            type: 'p',
            name: 'class',
            label: 'Class (pottery)'
          },
          VocPDecoration : {
            type: 'p',
            name: 'decoration',
            label: 'Decoration (pottery)'
          },
          VocPFiring : {
            type: 'p',
            name: 'firing',
            label: 'Firing'
          },
          VocPInclusionsFrequency : {
            type: 'p',
            name: 'inclusions-frequency',
            label: 'Inclusions Frequency'
          },
          VocPInclusionsSize : {
            type: 'p',
            name: 'inclusions-size',
            label: 'Inclusions Size'
          },
          VocPInclusionsType : {
            type: 'p',
            name: 'inclusions-type',
            label: 'Inclusions Type'
          },
          VocPPreservation : {
            type: 'p',
            name: 'preservation',
            label: 'Preservation (pottery)'
          },
          VocPShape : {
            type: 'p',
            name: 'shape',
            label: 'Shape'
          },
          VocPSurfaceTreatment : {
            type: 'p',
            name: 'surface-treatment',
            label: 'Surface Treatment'
          },
          VocSTType: {
            type: 's',
            name: 'type',
            label: 'Type (sample)'
          },
        }
      }
    },
    computed: {
      tables () {
        return this.rsTableMxTables
      },
      sortedVocabularyKey () {
        let keys = Object.keys(this.vocabularies)
        let vocs = this.vocabularies
        return keys.sort(function(a, b) {
            return vocs[a].label.localeCompare(vocs[b].label);
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