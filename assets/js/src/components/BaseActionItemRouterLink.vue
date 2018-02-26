<template>
    <router-link :to="route">
        <v-icon color="blue darken-1">{{icon}}</v-icon>
    </router-link>
</template>

<script>
  export default {
    name: 'base-action-item-router-link',
    props: {
      icon: {
        type: String,
        default: 'arrow_forward'
      },
      routeName: {
        type: String,
        default: 'data_item_read'
      },
      routeParams: {
        type: Object
      },
      id: {
        type: Number,
        required: true
      }
    },
    computed: {
      route () {
        let routeParams = this.routeParams || this.$route.params
        routeParams.id = this.id
        return {
          name: this.routeName,
          params: routeParams
        }
      }
    }
  }
</script>

<style scoped>

</style>