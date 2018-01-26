<template>
    <div>
        <component v-bind:is="actionComponent"
                   v-bind:id="id"
                   v-bind:tableName="tableName"
        />
    </div>

</template>

<script>
  export default {
    props: ['tableName', 'action', 'id'],
    components: {
      DataFormSiteCreate: () => import(
        /* webpackChunkName: "DataFormSiteCreate" */
        './DataFormSiteCreate'
        ),
      DataFormSiteRead: () => import(
        /* webpackChunkName: "DataFormSiteRead" */
        './DataFormSiteRead'
        ),
      DataFormSiteUpdate: () => import(
        /* webpackChunkName: "DataFormSiteUpdate" */
        './DataFormSiteUpdate'
        )
    },
    computed: {
      actionComponent: function () {
        let ucfirst = (string) =>
        {
          return string.charAt(0).toUpperCase() + string.slice(1);
        }
        return "DataForm" + ucfirst(this.tableName) + ucfirst(this.action)
      }
    },
    name: "DataForm"
  }
</script>

<style scoped>

</style>