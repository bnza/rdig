<template>
    <input
        class="input"
        v-bind:class="{'is-static': static}"
        v-bind:disabled="isRequestPending"
        v-bind:type="type"
        v-bind:placeholder="placeholder"
        v-bind:readonly="static"
        v-model="value"

    >
    <!--v-on:input="$emit('input')"-->
</template>

<script>
  export default {
    name: "base-form-input",
    props: {
      isRequestPending: {
        type: Boolean,
        default: function () {
          return false
        }
      },
      data: {
        required: true
      },
      fieldKey: {
        type: String
      },
      type: {
        type: String,
        default: function () {
          return 'text'
        },
        validator: function (value) {
          return ['text', 'email', 'password', 'tel'].indexOf(value) > -1
        }
      },
      placeholder: {
        type: String,
        default: function () {
          return ''
        }
      },
      static: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      value: {
        get () {
          return this.fieldKey ? this.data[this.fieldKey] : this.data
        },
        set (value) {
          if (this.fieldKey) {
            this.$set(this.data, this.fieldKey, value)
            //this.data[this.fieldKey] = value
          } else {
            this.data = value
          }
        }
      }
    }
  }
</script>

<style scoped>

</style>