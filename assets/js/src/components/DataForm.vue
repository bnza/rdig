<template>
    <component v-bind:is="actionComponent" v-bind:id="id"></component>
</template>

<script>
  export default {
    props: ['tablename', 'action', 'id'],
    components: {
      'DataFormSiteCreate': () => import(
        /* webpackChunkName: "DataFormSiteCreate" */
        './DataFormSiteCreate'
        ),
      'DataFormSiteRead': () => import(
        /* webpackChunkName: "DataFormSiteRead" */
        './DataFormSiteRead'
        )
    },
    computed: {
      actionComponent: function () {
        let ucfirst = (string) =>
        {
          return string.charAt(0).toUpperCase() + string.slice(1);
        }
        return "DataForm" + ucfirst(this.tablename) + ucfirst(this.action)
      }
    },
    name: "DataForm"
  }
</script>

<style scoped>

</style>