<script>
  import BaseFormInput from './BaseFormInput'
  export default {
    name: 'static-form-input',
    extends: BaseFormInput,
    props: {
      static: {
        type: Boolean,
        default: true,
        validator: function (value) {
          return !!value
        }
      }
    }
  }
</script>