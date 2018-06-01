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
        <v-toolbar-items>
            <v-tooltip bottom>
                <v-btn
                    v-if="$store.getters['account/isAuthenticated']"
                    icon
                    @click="$router.push(routingMxCreatePath)"
                    flat
                    slot="activator"
                >
                    <v-icon>add</v-icon>
                </v-btn>
                <span>Add new {{label}}</span>
            </v-tooltip>
            <v-tooltip bottom>
                <v-btn
                    v-if="$store.getters['account/isAuthenticated']"
                    icon
                    flat
                    @click="openDownloadModal"
                    slot="activator"
                >
                    <v-icon>save</v-icon>
                </v-btn>
                <span>Save as CSV</span>
            </v-tooltip>
            <v-tooltip bottom>
                <v-btn
                    icon
                    @click="openSearchModal"
                    flat
                    slot="activator"
                >
                    <v-icon>search</v-icon>
                </v-btn>
                <span>Open search dialog</span>
            </v-tooltip>
        </v-toolbar-items>
    </v-toolbar>
</template>

<script>
  import ListDataToolbar from './ListDataToolbar'

  export default {
    name: 'finding-list-data-toolbar',
    extends: ListDataToolbar,
    methods: {
      openDownloadModal () {
        this.$emit('forward', 'openDownloadModal')
      }
    }
  }
</script>