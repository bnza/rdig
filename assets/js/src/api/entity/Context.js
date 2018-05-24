import Area from './Area'
import Site from './Site'

const Context = class Context {
  constructor (item) {
    this.id = item.id
    this.code = item.code
    this.name = item.name
    this.type = item.type
    this.site = new Site(item.site)
    this.area = new Area(item.area)
    this.description = item.description
  }

  get typeName () {
    return this.types[this.type]
  }

  /**
   *
   * @returns {{B: string, D: string, F: string, G: string, L: string, P: string, S: string, W: string, X: string}}
   */
  get types () {
    return {
      B: 'bench',
      D: 'drain',
      F: 'fill',
      G: 'grave',
      L: 'locus',
      P: 'pitt',
      S: 'silos',
      W: 'wall',
      X: 'surface,'
    }
  }
}

export default Context
