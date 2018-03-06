<template>
    <v-toolbar
        :color="color"
        :dense="!!parent__"
        dark
    >
        <v-btn
            icon
            @click="routingMxGoToList"
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
                <v-list-tile @click="setChildTable">
                    <v-list-tile-title>User site privileges</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar>
</template>

<script>
  import ListDataToolbar from './ListDataToolbar'

  export default {
    name: 'user-item-data-toolbar',
    extends: ListDataToolbar,
    methods: {
      setChildTable () {
        this.$listeners.setChildList('user-allowed-sites')
      }
    }
  }
</script>

<style scoped>

</style>