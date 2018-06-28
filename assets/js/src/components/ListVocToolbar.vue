<template>
    <v-toolbar
        flat
        color="grey darken-2"
        dark
    >
        <v-toolbar-side-icon/>
        <v-toolbar-title>
            Vocabulary {{vocTitle($route.params.type, $route.params.name)}}
        </v-toolbar-title>
        <v-spacer/>
        <v-btn
            v-if="$store.getters['account/isAuthenticated']"
            icon
            @click="$emit('create',{})"
        >
            <v-icon>add</v-icon>
        </v-btn>
    </v-toolbar>
</template>

<script>
  export default {
    name: 'list-voc-toolbar',
    methods: {
      vocTitle(type, name) {
        const vocabularies = this.$store.state.vocabularies
        for (let key in vocabularies) {
          if (vocabularies[key].type === type && vocabularies[key].name === name) {
            return vocabularies[key].label
          }
        }
      }
    }
  }
</script>