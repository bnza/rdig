<template>
    <v-snackbar
        :timeout="6000"
        :color="color"
        top
        vertical
        v-model="active"
    >
        {{ text }}
        <v-btn dark flat @click.native="active = false">Close</v-btn>
    </v-snackbar>

</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  export default {
    name: "the-snack-bar",
    mixins: [
      UuidMx
    ],
    computed: {
      active: {
        get () {
          return this.uuidMxGet('active')
        },
        set (value) {
          return this.uuidMxSet('active', value)
        }
      },
      text: {
        get () {
          return this.uuidMxGet('text')
        },
        set (value) {
          return this.uuidMxSet('text', value)
        }
      },
      color: {
        get () {
          return this.uuidMxGet('color')
        },
        set (value) {
          return this.uuidMxSet('color', value)
        }
      }
    }
  }
</script>

<style scoped>
    .snack__content {
        font-size: 15px;
    }
</style>