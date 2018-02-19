<template>
    <base-read-form>
        <template v-if="form.hasData" slot-scope="form">
            <horizontal-form-field
                fieldKey="code"
                label="code"
                v-bind:violations="form.violations"
            >
                <static-form-input
                    type="text"
                    fieldKey="code"
                    v-bind:data="form.data"
                />
            </horizontal-form-field>
            <horizontal-form-field
                fieldKey="name"
                label="name"
                v-bind:violations="form.violations"
            >
                <static-form-input
                    type="text"
                    fieldKey="name"
                    v-bind:data="form.data"
                />
            </horizontal-form-field>
        </template>
    </base-read-form>
</template>

<script>
  import BaseReadForm from './BaseReadForm'
  import StaticFormInput from './StaticFormInput'
  import HorizontalFormField from './HorizontalFormField'

  export default {
    name: 'data-form-site-read',
    components:{
      BaseReadForm,
      HorizontalFormField,
      StaticFormInput
    }
  }
</script>