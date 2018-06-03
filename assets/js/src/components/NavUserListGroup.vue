<template>
    <v-list-group no-action>
        <v-list-tile slot="activator">
            <v-list-tile-action>
                <v-icon>settings</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Settings</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile
            @click="goToSetting('site-filter')"
        >
            <v-list-tile-content>
                <v-list-tile-title>Select Site</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
    </v-list-group>
</template>

<script>
  export default {
    name: 'nav-user-list-group',
    methods: {
      goToSetting (setting, prefix) {
        prefix = prefix || 'settings'
        const path = `${prefix}/${setting}`
        this.$router.push(path)
      }
    }
  }
</script>