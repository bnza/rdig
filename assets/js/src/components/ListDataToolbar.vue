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
            icon
            @click="$router.push(routingMxCreatePath)"
        >
            <v-icon>add</v-icon>
        </v-btn>
        <v-btn icon>
            <v-icon>search</v-icon>
        </v-btn>
    </v-toolbar>
</template>

<script>
  import BaseDataComponentToolbar from './BaseDataComponentToolbar'

  export default {
    name: 'list-data-toolbar',
    extends: BaseDataComponentToolbar
  }
</script>