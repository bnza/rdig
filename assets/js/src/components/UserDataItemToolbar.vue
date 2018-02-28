<template>
    <v-toolbar
        :color="color"
        :dense="!!parent__"
        dark
    >
        <v-btn
            icon
            @click="$emit('forward', 'pathMxGoToList')"
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
  import BaseDataListToolbar from "./BaseDataListToolbar"

  export default {
    name: 'user-data-item-toolbar',
    extends: BaseDataListToolbar,
    methods: {
      setChildTable () {
        this.$listeners.setChildList('user-allowed-sites')
      }
    }
  }
</script>

<style scoped>

</style>