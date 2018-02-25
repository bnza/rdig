<template>
    <base-form-control>
        <slot>
            <base-form-button v-bind:label="label"></base-form-button>
        </slot>
    </base-form-control>
</template>

<script>
  import BaseFormControl from './BaseFormControl'
  import BaseButtonControl from './BaseButtonControl'
  import BaseFormButton from "./BaseFormButton";
  export default {
    name: "base-button-control",
    components: {
      BaseFormButton,
      BaseFormControl,
      BaseButtonControl
    },
    props: {
      label: {
        type: String
      }
    }

  }
</script>