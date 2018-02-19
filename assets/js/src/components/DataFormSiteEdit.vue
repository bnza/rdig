<template>
    <base-edit-form>
        <template v-if="form.data" slot-scope="form">
            <horizontal-form-field
                fieldKey="code"
                label="code"
                v-bind:violations="form.violations"
                v-bind:isRequestPending="form.isRequestPending"
            >
                <base-form-input
                    type="text"
                    fieldKey="code"
                    v-bind:data="form.data"
                    v-bind:isRequestPending="form.isRequestPending"
                />
            </horizontal-form-field>
            <horizontal-form-field
                fieldKey="name"
                label="name"
                v-bind:violations="form.violations"
                v-bind:isRequestPending="form.isRequestPending"
            >
                <base-form-input
                    type="text"
                    fieldKey="name"
                    v-bind:data="form.data"
                    v-bind:isRequestPending="form.isRequestPending"
                />
            </horizontal-form-field>
        </template>
    </base-edit-form>
</template>

<script>
  import BaseEditForm from './BaseEditForm'
  import BaseFormInput from './BaseFormInput'
  import HorizontalFormField from './HorizontalFormField'

  export default {
    name: "data-form-site-edit",
    components:{
      BaseEditForm,
      HorizontalFormField,
      BaseFormInput
    }
  }
</script>