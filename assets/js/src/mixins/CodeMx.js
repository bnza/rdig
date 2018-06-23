export default {
  methods: {
    getDate(date) {
      if (date) {
        date = new Date(date.date);
        return date.toLocaleDateString();
      }
    },
    getBucketCode (bucket) {
      if (!bucket.campaign) {
        return undefined
      }
      const siteCode = bucket.campaign.site.code;
      const campaignYear = `${bucket.campaign.year}`.substr(-2)
      return `${siteCode}${campaignYear}.P.${bucket.num}`
    },
    getFindingFieldCode (finding) {
      if (!finding.bucket || !finding.num) {
        return undefined
      }
      // const siteCode = finding.bucket.campaign.site.code;
      // const campaignYear = `${finding.bucket.campaign.year}`.substr(-2)
      let num = finding.discr === 'S' ? `sample${finding.num}` : finding.num
      return `${this.getBucketCode(finding.bucket)}/${num}`
    },
    getFindingRegCode (finding) {
      if (!finding.no) {
        return undefined
      }
      const siteCode = finding.bucket.campaign.site.code;
      const campaignYear = `${finding.bucket.campaign.year}`.substr(-2)
      return `${siteCode}${campaignYear}.${finding.discr}.${finding.no}`
    }
  }
}