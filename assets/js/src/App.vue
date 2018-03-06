<template>
    <div id="app">
        <v-app>
            <the-right-navigation-drawer />
            <the-app-bar />
            <v-content>
                <v-container fluid>
                    <the-snack-bar/>
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
  import TheSnackBar from './components/TheSnackBar'
  import UuidMx from './mixins/UuidMx'

  export default {
    name: 'the-app',
    components: {
      TheAppBar,
      TheRightNavigationDrawer,
      TheSnackBar
    },
    mixins: [
      UuidMx
    ]
  }
</script>