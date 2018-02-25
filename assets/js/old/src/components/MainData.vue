<template>
    <div v-if="$route.params.table" class="has-text-left">
        <h1 class="is-size-2">{{$route.params.table}}</h1>
        <router-view>
        </router-view>
        <component
            v-if="$store.hasModal"
            v-is="$store.modalComponent"
        />
    </div>
</template>

<script>
  export default {
    name: "main-data"
  }
</script>