import Campaign from './Campaign'
import Context from './Context'

const Bucket = class Bucket {
  constructor (item) {
    this.id = item.id
    this.type = item.type
    this.num = item.name
    this.campaign = new Campaign(item.campaign)
    this.context = new Context(item.context)
  }

  get code () {
    let siteCode = this.campaign.site.code
    let prefix = `${siteCode}.${this.campaign.year}`
    if (['TH', 'TG'].indexOf(siteCode) > -1) {
      return `${prefix}.${this.context.area.code}.${this.num}`
    } else {
      return `${prefix}.${this.type}.${this.num}`
    }
  }

  get typeName () {
    return this.types[this.type]
  }

  /**
   *
   * @returns {{O: string, P: string, S: string}}
   */
  get types () {
    return {
      O: 'object',
      P: 'pottery',
      S: 'sample'
    }
  }
}

export default Bucket
