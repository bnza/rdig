<script>
  import RSTableMx from '../mixins/RSTableMx'
  import TableMx from '../mixins/TableMx'
  import QueryMx from '../mixins/QueryMx'
  import BaseDataComponent from './BaseDataComponent'
  import qs from 'qs'

  export default {
    name: 'base-data-table',
    extends: BaseDataComponent,
    mixins: [
      RSTableMx,
      TableMx
    ],
    data () {
      return {
/*        pagination: {
          page: 1,
          rowsPerPage: 25,
          sortBy: 'id',
          descending: false
        },
        dirty: false,
        loaded: false,*/
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
      /*searchCriteria: {
        get () {
          return this.uuidMxGet('searchCriteria')
        },
        set (value) {
          this.uuidMxSet('searchCriteria', value)
        }
      }*/
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
      getFindingCode (finding) {
        return `${this.getBucketCode(finding.bucket)}.${finding.num}`
      }
    },
    watch: {
      /*pagination: {
        handler (value, oldValue) {
          if (!this.dirty) {
            this.navigateToQuery()
            this.fetch()
          }
        },
        deep: true
      },
      searchCriteria: {
        handler (value, oldValue) {
          if (!this.dirty) {
            this.navigateToQuery()
            this.fetch()
          }
        },
        deep: true
      },*/
      reload (flag) {
        if (flag) {
          this.fetch()
        }
      }
    },
    /*created () {
      const pagination = this.paginationFromFullPath
      const searchCriteria = this.searchCriteriaFromFullPath
      if (pagination && searchCriteria) {
        this.dirty = true
        this.pagination = pagination
        this.dirty = false
        this.searchCriteria = searchCriteria
      }  else if (searchCriteria) {
        this.searchCriteria = searchCriteria
      } else if (pagination) {
        this.pagination = pagination
      }
    }*/
  }
</script>
