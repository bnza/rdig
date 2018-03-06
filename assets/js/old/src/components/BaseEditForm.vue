<template>
    <form>
        <header>
            <slot name="header" />
        </header>
        <main>
            <slot
                v-bind:data="data"
                v-bind:violations="violations"
                v-bind:isRequestPending="isRequestPending"
            />
        </main>
        <footer>
            <slot name="footer">
                <horizontal-edit-form-field-button-group
                    v-bind:isRequestPending="isRequestPending"
                    v-bind:isValid="isValid"
                    v-on:back="back"
                    v-on:submit="submitRequest"
                />
            </slot>
        </footer>
    </form>
</template>

<script>
  import BaseForm from './BaseForm'
  import HorizontalEditFormFieldButtonGroup from './HorizontalEditFormFieldButtonGroup'

  export default {
    name: "base-edit-form",
    extends: BaseForm,
    components: {
      HorizontalEditFormFieldButtonGroup
    },
    props: {
      deferValidation: {
        type: Boolean,
        default: function () {
          return true
        }
      }
    },
    methods: {
      back: function () {
        this.$router.push(this.listPath)
      }
    },
    computed: {
      isValid: function () {
        return this.deferValidation || Object.keys(this.violations).length === 0
      }
    }
  }
</script>