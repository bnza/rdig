<template>
    <div id="app">
        <TheTopAppNav/>
        <div id="container-main" class="container">
            <div class="columns is-centered">
                <div class="column is-2">
                    <TheLeftPanel/>
                </div>
                <div class="column is-9 has-text-centered">
                    <router-view/>
                </div>
                <div class="column is-2">
                    <p>Right</p>
                </div>
            </div>
        </div>
        <TheBottomAppNav/>
        <router-view name="modal"></router-view>
    </div>
</template>
s
<script>
  import TheTopAppNav from "./components/TheTopAppNav";
  import TheBottomAppNav from "./components/TheBottomAppNav";
  import TheLeftPanel from "./components/TheLeftPanel";

  export default {
    components: {TheTopAppNav, TheBottomAppNav, TheLeftPanel},
    name: 'App'
  }
</script>

<style scoped>

</style>