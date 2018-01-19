<template>
    <div class="has-text-left">
        <slot>
            <h1 class="is-size-1">{{tablename}}</h1>
        </slot>
        <router-view v-bind:tablename="tablename"></router-view>
    </div>
</template>

<script>
  export default {
    props:[
      'tablename'
    ],
    name: "MainData"
  }
</script>

<style scoped>

</style>