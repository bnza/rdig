export default {
  props: {
    prefix__: {
      type: String,
      required: true,
      validator (value) {
        return ['data', 'admin'].indexOf(value) > -1
      }
    },
    table__: {
      type: String,
      required: true
    },
    parent__: {
      type: Object,
      validator (value) {
        return value.hasOwnProperty('table') && value.hasOwnProperty('id')
      }
    },
    id__: {
      type: [Number, String],
      validator (value) {
        return /^\d*,?\d*$/.test(value)
      }
    }
  }
}