<template>
    <component
        v-bind:is="itemReadComponent"
    />
</template>

<script>
  import {pascalize} from '../util'

  export default {
    name: "the-data-item",
    components: {
      SiteReadDataItem: () => import(
        /* webpackChunkName: "SiteReadDataItem" */
        './SiteReadDataItem'
        )
    },
    computed: {
      itemReadComponent: function () {
        return `${pascalize(this.$route.params.table)}ReadDataItem`
      }
    },
  }
</script>

<style scoped>

</style>