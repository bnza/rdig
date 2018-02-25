<template>
    <div class="control">
        <component
            v-if="uuid"
            ref="input"
            v-bind:class="classObject"
            v-bind:is="inputComponent"
            v-bind:uuid="uuid"
            v-bind:fieldKey="fieldKey"
        >
        </component>
    </div>
</template>

<script>
  import {mapGetters} from 'vuex'

  export default {
    name: "base-form-control",
    components: {
      BaseFormInput: () => import(
        /* webpackChunkName: "BaseFormInput" */
        './BaseFormInput'
        )
    },
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
        _controlInputComponentGetterFn: 'controlInputComponentFn'
      }),
      inputComponent: function () {
        return this._controlInputComponentGetterFn(this.uuid, this.fieldKey)
      },
      classObject: function () {
        return {}
      }
    }
  }
</script>