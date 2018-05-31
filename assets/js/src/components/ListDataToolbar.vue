<template>
    <v-toolbar
        flat
        :color="color"
        :dense="!!parent__"
        dark
    >
        <v-btn
            v-if="!!parent__"
            icon
            @click="$listeners.setChildList('')"
        >
            <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-side-icon v-else/>
        <v-toolbar-title>
            {{label}}
        </v-toolbar-title>
        <v-spacer/>
        <v-btn
            v-if="$store.getters['account/isAuthenticated']"
            icon
            @click="$router.push(routingMxCreatePath)"
        >
            <v-icon>add</v-icon>
        </v-btn>
        <v-btn icon
               @click="openSearchModal"
        >
            <v-icon>search</v-icon>
        </v-btn>
    </v-toolbar>
</template>

<script>
  import BaseDataComponentToolbar from './BaseDataComponentToolbar'
  import {uuidMxSet} from '../mixins/UuidMx'

  export default {
    name: 'list-data-toolbar',
    extends: BaseDataComponentToolbar,
    methods: {
      openSearchModal () {
        uuidMxSet(this.$store, 'callerUuid', this.dCuid, 'the-search-modal')
        this.$router.push(this.routingMxSearchPath)
      }
    }
  }
</script>