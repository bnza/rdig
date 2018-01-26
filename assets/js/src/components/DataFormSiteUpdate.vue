<template>
    <DataFormSiteEdit method="put" v-bind:id="id"/>
</template>

<script>
  import DataFormSiteEdit from './DataFormSiteEdit'

  export default {
    props: ['id'],
    components: {
      DataFormSiteEdit
    },
    name: "DataFormSiteUpdate"
  }
</script>

<style scoped>

</style>