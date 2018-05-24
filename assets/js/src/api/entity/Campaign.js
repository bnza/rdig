import Site from './Site'

const Campaign = class Campaign {
  constructor (item) {
    this.id = item.id
    this.year = item.year
    this.site = new Site(item.site)
    this.name = item.name
  }

  /**
   *
   * @returns {string}
   */
  get code () {
    return `${this.site.code}.${this.year}`
  }
}

export default Campaign
