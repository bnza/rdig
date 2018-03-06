<template>
    <v-layout row wrap>
        <v-flex xs4>
            <v-text-field readonly label="Username" v-model="username"/>
        </v-flex>
        <v-flex xs8>
            <v-text-field readonly label="Roles" v-model="roles"/>
        </v-flex>
    </v-layout>
</template>

<script>
  import Vue from 'vue'
  export default {
    name: 'site-read-fields-item',
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    computed: {
      username: {
        get () {
          return this.item.username
        },
        set (value) {
          Vue.set(this.item, 'username', value)
        }
      },
      roles: {
        get () {
          return this.item.roles
        },
        set (value) {
          Vue.set(this.item, 'roles', value)
        }
      }
    }
  }
</script>

<style scoped>

</style>