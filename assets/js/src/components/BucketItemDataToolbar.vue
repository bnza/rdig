<template>
    <v-toolbar
        :color="color"
        :dense="!!parent__"
        dark
    >
        <v-btn
            icon
            @click="$router.go(-1)"
        >
            <v-icon>arrow_back</v-icon>
        </v-btn>
        <v-toolbar-title>
            {{rsTableMxTable.label}}
        </v-toolbar-title>
        <v-spacer/>
        <v-menu offset-y>
            <v-btn icon slot="activator">
                <v-icon>more_vert</v-icon>
            </v-btn>
            <v-list>
                <!--<v-list-tile
                    v-if="item"
                    @click="setChildTable(childSpecTable)"
                >
                    <v-list-tile-title>{{ capitalize(childSpecTable) }}</v-list-tile-title>
                </v-list-tile>-->
                <v-list-tile
                    v-if="item"
                    @click="navigateToChild('object')"
                >
                    <v-list-tile-title>Object</v-list-tile-title>
                </v-list-tile>
                <v-list-tile
                    v-if="item"
                    @click="navigateToChild('pottery')"
                >
                    <v-list-tile-title>Pottery</v-list-tile-title>
                </v-list-tile>
                <v-list-tile
                    v-if="item"
                    @click="navigateToChild('sample')"
                >
                    <v-list-tile-title>Sample</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar>
</template>

<script>
  import ItemDataToolbar from './ItemDataToolbar'
  import {capitalize} from '../util'

  export default {
    name: 'bucket-item-data-toolbar',
    extends: ItemDataToolbar,
    computed: {
      childSpecTable () {
        const specs = {
          O: 'object',
          P: 'pottery',
          S: 'sample'
        }
        return specs[this.item.type]
      }
    },
    methods: {
      capitalize (string) {
        return string ? capitalize(string) : string
      },
      navigateToChild (table) {
        this.$router.push({
          name: 'data_child_list_read',
          params: {
            prefix: 'data',
            table: 'bucket',
            id: this.$route.params.id,
            childTable: table,
            action: 'read'
          }
        })
      }
    }
  }
</script>

<style scoped>

</style>