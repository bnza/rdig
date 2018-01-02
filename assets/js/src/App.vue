<template>
    <div id="app">
        <app-nav-top></app-nav-top>
        <div class="container">
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
    </div>
</template>

<script>
  import AppNavTop from "./components/AppNavTop";
  import AppNavBottom from "./components/AppNavBottom";
  import PanelLeft from "./components/PanelLeft";

  export default {
    components: {AppNavTop, AppNavBottom, PanelLeft},
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