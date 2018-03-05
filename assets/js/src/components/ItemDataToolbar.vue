<template>
    <v-toolbar
        flat
        :color="color"
        :dense="!!parent__"
        dark
    >
        <v-btn
            icon
            @click="goToList('read')"
        >
            <v-icon>arrow_back</v-icon>
        </v-btn>
        <v-toolbar-title>
            {{label}}
        </v-toolbar-title>
        <!--<v-spacer/>-->
    </v-toolbar>
</template>

<script>
  import BaseDataComponentToolbar from './BaseDataComponentToolbar'

  export default {
    name: 'item-data-item-toolbar',
    extends: BaseDataComponentToolbar
  }
</script>