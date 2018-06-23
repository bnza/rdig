<script>
  import UuidMx from '../mixins/UuidMx'
  import DataMx from '../mixins/DataMx'
  import RoutingMx from '../mixins/RoutingMx'

  export default {
    name: 'base-data-component',
    mixins: [
      DataMx,
      UuidMx,
      RoutingMx
    ],
    props: {
      uuidMxRegister: {
        type: Boolean,
        default: true
      }
    },
    data() {
      return {
        isRequestPending: false
      }
    },
    methods: {
      getDate(date) {
        if (date) {
          date = new Date(date.date);
          return date.toLocaleDateString();
        }
      },
      getFindingFieldCode (finding) {
        if (!finding.bucket || !finding.num) {
          return undefined
        }
        const siteCode = finding.bucket.campaign.site.code;
        const campaignYear = `${finding.bucket.campaign.year}`.substr(-2)
        let num = finding.discr === 'S' ? `sample${finding.num}` : finding.num
        return `${siteCode}${campaignYear}.P.${finding.bucket.num}/${num}`
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
</script>