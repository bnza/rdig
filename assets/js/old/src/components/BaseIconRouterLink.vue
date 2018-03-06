<template>
    <!-- TODO check authorization -->
    <router-link
        v-if="true"
        v-bind:to="path"
        v-bind:title="title"
    >
        <span class="icon has-text-success is-pulled-right">
            <i class="fa fa-2x" v-bind:class="icon"></i>
        </span>
    </router-link>
    <span v-else class="icon has-text-grey-lighter is-pulled-right">
        <i class="fa fa-2x" v-bind:class="icon"></i>
    </span>
</template>

<script>
  import AuthorizationHelperMixin from '../mixins/AuthorizationHelperMixin'

  export default {
    name: "base-icon-router-link",
    mixins: {
      AuthorizationHelperMixin
    },
    props: {
      path: {
        type: String,
        required: true
      },
      title: {
        type: String,
        default: ''
      },
      icon: {
        type: String,
        required: true
      }
    }
  }
</script>

<style scoped>

</style>