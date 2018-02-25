<template>
    <div id="app">
        <v-app>
            <the-right-navigation-drawer />
            <the-app-bar />
            <v-content>
                <v-container fluid>
                    <router-view/>
                    <router-view name="modals"></router-view>
                </v-container>
            </v-content>
            <v-footer app/>
        </v-app>
    </div>
</template>

<script>
  import TheAppBar from './components/TheAppBar'
  import TheRightNavigationDrawer from './components/TheRightNavigationDrawer'
  import UuidMx from './mixins/UuidMx'

  export default {
    name: 'the-app',
    components: {
      TheAppBar,
      TheRightNavigationDrawer
    },
    mixins: [
      UuidMx
    ]
  }
</script>