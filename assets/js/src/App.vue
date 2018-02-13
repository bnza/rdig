<template>
    <div id="app">
        <TheTopAppNav/>
        <div id="container-main" class="container">
            <div class="columns is-centered">
                <div class="column is-2">
                    <TheLeftPanel/>
                </div>
                <div class="column is-9 has-text-centered">
                    <MessagesContainer/>
                    <router-view/>
                </div>
                <div class="column is-2">
                    <p>Right</p>
                </div>
            </div>
        </div>
        <TheBottomAppNav/>
        <router-view name="modal"/>
        <component
            v-if="$store.hasModal"
            v-is="$store.modal.component"
            v-bind:props="$store.modal.props"
        />
    </div>
</template>

<script>
  import TheTopAppNav from './components/TheTopAppNav';
  import TheBottomAppNav from './components/TheBottomAppNav';
  import TheLeftPanel from './components/TheLeftPanel';
  import MessagesContainer from './components/MessagesContainer'

  export default {
    beforeCreate: function () {
      if (window.user) {
        this.$store.commit('account/SET_USER', window.user)
        delete window.user
      }
      let el = document.getElementById("user-data")
      if (el) {
        el.remove()
      }
    },
    components: {
      MessagesContainer,
      TheTopAppNav,
      TheBottomAppNav,
      TheLeftPanel
    },
    name: 'App'
  }
</script>

<style scoped>

</style>