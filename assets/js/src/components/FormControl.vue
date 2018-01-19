<template>
    <div class="control" v-bind:class="hasIconsClassObject">
        <slot></slot>
        <span v-if="hasIconsClassObject.hasIconsLeft" class="icon is-small is-left">
            <i class="fas" v-bind:class="leftIconClassObject"></i>
        </span>
        <span v-if="hasIconsClassObject.hasIconsRight" class="icon is-small is-right">
            <i class="fas" v-bind:class="rightIconClassObject"></i>
        </span>
    </div>
</template>

<script>
  export default {
    data: function() {
      return {
        value: null
      }
    },
    props: {
      icons: {
        type: Object,
        default: function () {
          return {}
        }
      }
    },
    computed: {
      hasIconsClassObject: function () {
        let classObject = {}
        if (this.icons.hasOwnProperty('left')) {
          classObject.hasIconsLeft = true
        }
        if (this.icons.hasOwnProperty('right')) {
          classObject.hasIconsRight = true
        }
        return classObject;
      },
      leftIconClassObject: function () {
        let classObject = {}
        if (this.icons.hasOwnProperty('left')) {
          classObject[this.icons.left] = true
          return classObject
        }
      },
      rightIconClassObject: function () {
        let classObject = {}
        if (this.icons.hasOwnProperty('right')) {
          classObject[this.icons.right] = true
          return classObject
        }
      }
    },
    methods: {
      onChange: function () {
        this.$emit('input',this.value)
      }
    },
    name: "FormControl"
  }
</script>

<style scoped>

</style>