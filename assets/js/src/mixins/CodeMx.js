export default {
  methods: {
    getDate (date) {
      if (date) {
        date = new Date(date.date)
        return date.toLocaleDateString()
      }
    },
    getCampaignCode (campaign) {
      if (!campaign.site || !campaign.year) {
        return undefined
      }
      const campaignYear = `${campaign.year}`.substr(-2)
      return `${campaign.site.code}.${campaignYear}`
    },
    getBucketBaseCode (bucket) {
      if (!bucket || !bucket.campaign) {
        return undefined
      }
      return `P.${bucket.num}`
    },
    getBucketCode (bucket) {
      if (!bucket || !bucket.campaign) {
        return undefined
      }
      return `${this.getCampaignCode(bucket.campaign)}.P.${bucket.num}`
    },
    getFindingFieldCode (finding) {
      if (!finding.bucket || !finding.num) {
        return undefined
      }
      let num = finding.discr === 'S' ? `sample${finding.num}` : finding.num
      return `${this.getBucketCode(finding.bucket)}/${num}`
    },
    getFindingRegCode (finding) {
      // Finding table has not discr field
      const group = finding.discr || finding.group
      if (group !== 'P' && !finding.no) {
        return undefined
      } else if (!finding.num) {
        return undefined
      }
      const fieldNum = finding.discr === 'P' ? finding.num : finding.no
      const duplicate = finding.duplicate || ''
      return `${this.getCampaignCode(finding.bucket.campaign)}.${group}.${fieldNum}${duplicate}`
    }
  }
}
