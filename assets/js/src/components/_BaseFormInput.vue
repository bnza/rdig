<template>
    <input
        v-model="value"
        class="input"
        v-bind:class="classObject"
        v-bind:type="type"
        placeholder="Text input"
    >
</template>

<script>
  import {mapGetters} from 'vuex'

  export default {
    name: "base-form-input",
    props: {
      uuid: {
        type: Number,
        required: true
      },
      fieldKey: {
        required: true,
        type: String
      }
    },
    computed: {
      ...mapGetters('components/forms', {
        _inputColorClassGetterFn: 'inputColorClassFn',
        _inputSizeClassGetterFn: 'inputSizeClassFn',
        _inputStateClassGetterFn: 'inputStateClassFn',
        _inputTypeGetterFn: 'inputTypeFn',
        _fieldDataGetterFn: 'fieldData'

      }),
      classObject: function () {
        let classes = {}
        let colorClass = this._inputColorClassGetterFn(this.uuid, this.fieldKey)
        if (colorClass) {
          classes[colorClass] = true
        }
        let sizeClass = this._inputSizeClassGetterFn(this.uuid, this.fieldKey)
        if (sizeClass) {
          classes[sizeClass] = true
        }
        let stateClasses = this._inputStateClassGetterFn(this.uuid, this.fieldKey)
        for (let i in stateClasses) {
          classes[stateClasses[i]] = true
        }
        return classes
      },
      type: function () {
        return this._inputTypeGetterFn(this.uuid, this.fieldKey)
      },
      value: {
        get () {
          return this._fieldDataGetterFn(this.uuid, this.fieldKey)
        },
        set (value) {
          this.$store.dispatch({
            type: 'components/forms/setValue',
            uuid: this.uuid,
            fieldKey: this.fieldKey,
            value: value
          })
        }
      }
    }
  }
</script>

<style scoped>

</style>