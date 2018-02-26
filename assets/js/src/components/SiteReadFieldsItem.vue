<template>
    <v-layout row wrap>
        <v-flex xs3 sm2>
            <v-text-field readonly label="Code" v-model="code"/>
        </v-flex>
        <v-flex xs9 sm10>
            <v-text-field readonly label="Name" v-model="name"/>
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
      code: {
        get () {
          return this.item.code
        },
        set (value) {
          Vue.set(this.item, 'code', value)
        }
      },
      name: {
        get () {
          return this.item.name
        },
        set (value) {
          Vue.set(this.item, 'code', value)
        }
      }
    }
  }
</script>

<style scoped>

</style>