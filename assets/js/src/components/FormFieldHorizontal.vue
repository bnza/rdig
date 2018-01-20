<template>
    <div class="field is-horizontal">
        <div v-if="label" class="field-label is-normal">
            <label class="label">{{label}}</label>
        </div>
        <div class="field-body">
            <slot>
                <FormField/>
            </slot>
        </div>
    </div>
    
</template>

<script>
  import FormField from './FormField'

  export default {
    components: {
      FormField
    },
    props: {
      label: {
        type: String,
        default: ''
      }
    },
    name: "FormFieldHorizontal"
  }
</script>

<style scoped>

</style>