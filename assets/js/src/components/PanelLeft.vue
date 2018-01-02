<template>
    <div v-bind:is="currentView">
        <!-- component changes when vm.currentView changes! -->
    </div>
</template>

<script>
  import MenuLeft from "./MenuLeft";
  import TestLeft from "./TestLeft";

  export default {
    computed : {
        currentView () {
          return this.$store.state.panelLeftComponent
        }
    },
    components: {MenuLeft, TestLeft},
    name: "panel-left"
  }
</script>

<style scoped>

</style>