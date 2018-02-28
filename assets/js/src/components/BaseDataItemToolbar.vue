<template>
    <v-toolbar
        flat
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
            {{label}}
        </v-toolbar-title>
        <!--<v-spacer/>-->
    </v-toolbar>
</template>

<script>
  import BaseDataComponentToolbar from './BaseDataComponentToolbar'

  export default {
    name: 'base-data-item-toolbar',
    extends: BaseDataComponentToolbar
  }
</script>