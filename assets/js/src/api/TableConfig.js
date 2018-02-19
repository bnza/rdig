export default class tableConfig {
  constructor (options) {
    this.defaultOptions = {
      component: 'BaseTableBody',
      header: {
        component: 'BaseTableHeader'
      }
    }
    this.defaultColumnOptions = {
      visible: true,
      body: {
        component: 'BaseTableDataCell'
      },
      header: {
        component: 'SortableTableHeaderCell'
      }
    }
    this.component = options.component || this.defaultOptions.component
    this.header = Object.assign({}, this.defaultOptions.header, options.header)
    this.columns = {}
    for (let key in options.columns) {
      let column = {}
      let defaultColumnOption = JSON.parse(JSON.stringify(this.defaultColumnOptions))
      if (key === 'id') {
        defaultColumnOption.body.component = 'ShowTableDataCell'
      }
      let columnOption = JSON.parse(JSON.stringify(options.columns[key]))
      Object.assign(column, defaultColumnOption, columnOption)
      if (!column.hasOwnProperty('label')) {
        column.label = key
      }
      if (!column.body.hasOwnProperty('field')) {
        column.body.field = key
      }
      this.columns[key] = column
    }
  }

  get columnsNumber () {
    return Object.keys(this.columns).length
  }
}
