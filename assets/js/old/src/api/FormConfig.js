import merge from 'deepmerge'

const INPUT_SIZE_IS_NORMAL = ['']
const INPUT_SIZE_IS_SMALL = ['is-small']
const INPUT_SIZE_IS_MEDIUM = ['is-medium']
const INPUT_SIZE_IS_LARGE = ['is-large']
const INPUT_SIZES = [
  INPUT_SIZE_IS_NORMAL,
  INPUT_SIZE_IS_SMALL,
  INPUT_SIZE_IS_MEDIUM,
  INPUT_SIZE_IS_LARGE
]

const INPUT_COLOR_NONE = ['']
const INPUT_COLOR_IS_PRIMARY = ['is-primary']
const INPUT_COLOR_IS_INFO = ['is-info']
const INPUT_COLOR_IS_SUCCESS = ['is-success']
const INPUT_COLOR_IS_WARNING = ['is-warning']
const INPUT_COLOR_IS_DANGER = ['is-danger']
const INPUT_COLORS = [
  INPUT_COLOR_NONE,
  INPUT_COLOR_IS_PRIMARY,
  INPUT_COLOR_IS_INFO,
  INPUT_COLOR_IS_SUCCESS,
  INPUT_COLOR_IS_WARNING,
  INPUT_COLOR_IS_DANGER
]

const INPUT_STATE_IS_HOVERED = ['is-hovered']
const INPUT_STATE_IS_FOCUSED = ['is-focused']
const INPUT_STATE_IS_LOADING = ['is-loading']
const INPUT_STATE_IS_STATIC = ['is-static']
const INPUT_STATES = [
  INPUT_STATE_IS_HOVERED,
  INPUT_STATE_IS_FOCUSED,
  INPUT_STATE_IS_LOADING,
  INPUT_STATE_IS_STATIC
]

const defaultOptions = {
  component: 'BaseForm',
  fieldType: 'BaseFormField',
  fields: {
    key: {
      component: 'BaseFormField',
      input: {
        type: 'text',
        component: 'BaseFormInput',
        states: [],
        color: '',
        size: ''
      },
      control: {
        component: 'BaseFormControl'
      }
    }
  }
}

export default class TableConfig {
  constructor (options) {
    this.defaultOptions = JSON.parse(JSON.stringify(defaultOptions))
    this.component = options.component || this.defaultOptions.component
    this.fields = {}
    for (let fieldKey in options.fields) {
      let defaultFieldOption = JSON.parse(JSON.stringify(defaultOptions.fields.key))
      let fieldOption = JSON.parse(JSON.stringify(options.fields[fieldKey]))
      let field = merge(defaultFieldOption, fieldOption)
      if (!field.hasOwnProperty('label')) {
        field.label = fieldKey
      }
      this.fields[fieldKey] = field
    }
  }
  getField (fieldKey) {
    if (!this.fields.hasOwnProperty(fieldKey)) {
      throw new Error(`${fieldKey} field does not exist`)
    }
    return this.fields[fieldKey]
  }
  toggleInputStatus (fieldKey, status) {
    if (INPUT_STATES.indexOf(status) === -1) {
      throw new Error(`Invalid input state: ${status}`)
    }
    let input = this.getField(fieldKey)
    const i = input.states.indexOf(status)
    if (i === -1) {
      input.states.push(status)
    } else {
      input.states.splice(i, 1)
    }
  }
  getFieldComponent (fieldKey) {
    return this.getField(fieldKey).component
  }
  getControlComponent (fieldKey) {
    return this.getField(fieldKey).control.component
  }
  getInputType (fieldKey) {
    return this.getField(fieldKey).input.type
  }
  getInputComponent (fieldKey) {
    return this.getField(fieldKey).input.component
  }
  getInputColor (fieldKey) {
    return this.getField(fieldKey).input.color
  }
  setInputColor (fieldKey, color) {
    if (INPUT_COLORS.indexOf(color) === -1) {
      throw new Error(`Invalid input color: ${color}`)
    }
    this.getField(fieldKey).input.color = color
  }
  getInputSize (fieldKey, size) {
    return this.getField(fieldKey).input.size
  }
  setInputSize (fieldKey, size) {
    if (INPUT_SIZES.indexOf(size) === -1) {
      throw new Error(`Invalid input size: ${size}`)
    }
    this.getField(fieldKey).input.size = size
  }
  getInputStates (fieldKey, size) {
    return this.getField(fieldKey).input.states
  }
}
