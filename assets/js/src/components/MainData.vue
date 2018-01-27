<template>
    <div v-if="tableName" class="has-text-left">
        <h1 class="is-size-2">{{tableName}}</h1>
        <router-view v-bind:tableName="tableName"></router-view>
    </div>
</template>

<script>
  export default {
    props:[
      'tableName'
    ],
    name: "MainData"
  }
</script>

<style scoped>

</style>