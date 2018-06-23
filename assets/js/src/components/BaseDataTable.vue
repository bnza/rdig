<script>
  import RSTableMx from '../mixins/RSTableMx'
  import TableMx from '../mixins/TableMx'
  import BaseDataComponent from './BaseDataComponent'

  export default {
    name: 'base-data-table',
    extends: BaseDataComponent,
    mixins: [
      RSTableMx,
      TableMx
    ],
    data () {
      return {
        items: [],
        totalItems: 0
      }
    },
    computed: {
      reload : {
        get () {
          return typeof this.$route.meta.reload !== 'undefined'
            ? this.$route.meta.reload
            : !this.loaded
        },
        set (value) {
          this.loaded = !value
        }
      },
    },
    methods: {
      fetch () {
        this.tableMxFetch()
        this.loaded = true
        this.$route.meta.reload = false
      },
      getVocabularyValue(vocItem)
      {
        if (vocItem && vocItem.hasOwnProperty('value'))
        {
          return vocItem.value
        }
      },
      trimTableCellContent(content, length) {
        length = length || 15;
        return content && content.length > length
          ? `${content.substr(0, length)}...`
          : content
      },
      getBucketCode (bucket) {
        let siteCode = bucket.campaign.site.code;
        const campaignYear = `${bucket.campaign.year}`.substr(-2)
        if (['TH', 'TG'].indexOf(siteCode) > -1) {
          return `${siteCode}.${campaignYear}.${bucket.context.area.code}.${bucket.num}`
        } else {
          return `${siteCode}.${campaignYear}.${bucket.type}.${bucket.num}`
        }
      },
      getContextCode (context) {
        return `${context.type}.${context.num}`
      },
      /*getFindingFieldCode (finding) {
        const siteCode = finding.bucket.campaign.site.code;
        const campaignYear = `${finding.bucket.campaign.year}`.substr(-2)
        let num = finding.discr === 'S' ? `sample${finding.num}` : finding.num
        return `${siteCode}.${campaignYear}.P.${finding.bucket.num}/${num}`
      },
      getFindingRegCode (finding) {
        if (!finding.no) {
          return undefined
        }
        const siteCode = finding.bucket.campaign.site.code;
        return `${siteCode}.${finding.discr}.${finding.no}`
      }*/
    },
    watch: {
      reload (flag) {
        if (flag) {
          this.fetch()
        }
      }
    },
  }
</script>
