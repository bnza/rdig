<template>
    <v-toolbar
        :color="color"
        :dense="!!parent__"
        dark
    >
        <v-btn
            icon
            @click="routingMxGoToList"
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
                <v-list-tile @click="setChildTable('user-allowed-sites')">
                    <v-list-tile-title>User site privileges</v-list-tile-title>
                </v-list-tile>
                <v-divider />
                <v-list-tile @click="$emit('forward', 'openResetUserPasswordModal')">
                    <v-list-tile-title>Reset user password</v-list-tile-title>
                </v-list-tile>
                <v-list-tile @click="$emit('forward', 'openResetLoginAttemptsModal')">
                    <v-list-tile-title>Reset login attempts</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar>
</template>

<script>
  import ItemDataToolbar from './ItemDataToolbar'

  export default {
    name: 'user-item-data-toolbar',
    extends: ItemDataToolbar,
  }
</script>

<style scoped>

</style>