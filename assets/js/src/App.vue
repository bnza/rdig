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
  import Cookies from 'js-cookie';
  import TheAppBar from './components/TheAppBar'
  import TheRightNavigationDrawer from './components/TheRightNavigationDrawer'
  import TheSnackBar from './components/TheSnackBar'
  import UuidMx from './mixins/UuidMx'

  export default {
    name: 'the-app',
    beforeCreate: function () {
      if (window.user) {
        this.$store.commit('account/SET_USER', window.user)
        delete window.user
      }
      let el = document.getElementById("user-data")
      if (el) {
        el.remove()
      }
      const token = Cookies.get('xsrf-token')
      if (token) {
        this.$store.commit('SET_TOKEN', token)
        Cookies.remove('xsrf-token');
      }
    },
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