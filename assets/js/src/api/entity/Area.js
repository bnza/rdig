import Site from './Site'

const Area = class Area {
  constructor (item) {
    this.id = item.id
    this.code = item.code
    this.name = item.name
    this.site = new Site(item.site)
  }
}

export default Area
