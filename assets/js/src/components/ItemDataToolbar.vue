<template>
    <v-toolbar
        flat
        :color="color"
        :dense="!!parent__"
        dark
    >
        <v-btn
            flat
            icon
            @click="goToList('read')"
        >
            <v-icon>arrow_back</v-icon>
        </v-btn>
        <v-toolbar-title>
            {{label}}
        </v-toolbar-title>
        <v-spacer/>
        <v-btn
            flat
            icon
            @click.native="setChildTable()"
        >
            <v-icon>expand_more</v-icon>
        </v-btn>
    </v-toolbar>
</template>

<script>
  import BaseDataComponentToolbar from './BaseDataComponentToolbar'

  export default {
    name: 'item-data-item-toolbar',
    extends: BaseDataComponentToolbar,
    methods: {
      setChildTable (table) {
        if (!table) {
          const children = {
            site: 'area'
          }
          table = children[this.table__]
        }
        this.$listeners.setChildList(table)
      }
    }
  }
</script>