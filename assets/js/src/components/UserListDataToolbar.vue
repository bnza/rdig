<template>
    <v-toolbar
        color="indigo darken-4"
        dark
    >
        <v-toolbar-side-icon/>
        <v-toolbar-title>
            User
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
        <v-menu offset-y>
            <v-btn icon slot="activator">
                <v-icon>more_vert</v-icon>
            </v-btn>
            <v-list>
                <v-list-tile @click="">
                    <v-list-tile-title>User site privileges</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar>
</template>

<script>
  import ListDataToolbar from './ListDataToolbar'
  import RSTableMx from '../mixins/RSTableMx'

  export default {
    name: 'user-list-data-toolbar',
    extends: ListDataToolbar,
    mixins: [
      RSTableMx
    ]
  }
</script>