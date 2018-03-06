<template>
    <div class="field" v-bind:class="{'is-grouped': grouped}">
        <label v-if="label" class="label">{{label}}</label>
        <base-form-control v-if="!grouped">
            <slot />
        </base-form-control>
        <slot v-else />
        <p class="help" v-if="violation" v-bind:class="{'is-danger': violation}">{{violation}}</p>
    </div>
</template>

<script>
  import BaseFormControl from './BaseFormControl'
  export default {
    name: "base-form-field",
    components: {
      BaseFormControl
    },
    props: {
      fieldKey: {
        type: String
      },
      grouped: {
        type: Boolean,
        default: false
      },
      label: {
        type: String,
        default: ''
      },
      violations: {
        type: Object
      }
    },
    computed: {
      violation: function () {
        return this.fieldKey && this.violations ? this.violations[this.fieldKey] : false
      }
    }
  }
</script>