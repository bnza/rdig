<template>
    <div class="field">
        <label class="label">{{label}}</label>
        <component
            v-if="uuid"
            ref="control"
            v-bind:class="classObject"
            v-bind:is="controlComponent"
            v-bind:uuid="uuid"
            v-bind:fieldKey="fieldKey"
        >
        </component>
    </div>
</template>

<script>
  import {mapGetters} from 'vuex'

  export default {
    name: "base-form-field",
    components: {
      BaseFormControl: () => import(
        /* webpackChunkName: "BaseFormControl" */
        './BaseFormControl'
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
        _fieldControlComponentGetterFn: 'fieldControlComponentFn',
        _fieldLabelGetterFn: 'fieldLabel'
      }),
      controlComponent: function () {
        return this._fieldControlComponentGetterFn(this.uuid, this.fieldKey)
      },
      label: function () {
        return this._fieldLabelGetterFn(this.uuid, this.fieldKey)
      },
      classObject: function () {
        return {}
      }

    }
  }
</script>

<style scoped>

</style>