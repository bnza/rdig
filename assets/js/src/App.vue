<template>
    <div id="app">
        <app-nav-top></app-nav-top>
        <div id="container-main" class="container">
            <div class="columns is-centered">
                <div class="column is-2">
                    <panel-left></panel-left>
                </div>
                <div class="column is-9 has-text-centered">
                    <router-view></router-view>
                    <div><p><strong>App</strong>!!! {{message}}</p></div>
                </div>
                <div class="column is-2">
                    <p>Right</p>
                </div>
            </div>
        </div>
        <app-nav-bottom></app-nav-bottom>
        <div class="components">
            <login-form></login-form>
        </div>
    </div>
</template>

<script>
  import AppNavTop from "./components/AppNavTop";
  import AppNavBottom from "./components/AppNavBottom";
  import PanelLeft from "./components/PanelLeft";
  import LoginForm from "./components/LoginForm";

  export default {
    components: {AppNavTop, AppNavBottom, PanelLeft, LoginForm},
    name: "app",
    data () {
      return {
        message: '(computed)'
      }
    }
  }
</script>

<style scoped>

</style>