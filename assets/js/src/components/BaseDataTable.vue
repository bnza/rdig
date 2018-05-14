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
        pagination: {
          page: 1,
          rowsPerPage: 10,
          sortBy: 'id'
        },
        loaded: false,
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
      searchCriteria: {
        get () {
          return this.uuidMxGet('searchCriteria')
        },
        set (value) {
          this.uuidMxSet('searchCriteria', value)
        }
      }
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
      getDate(date) {
        date = new Date(date.date);
        return date.toLocaleDateString();
      },
      getBucketCode (bucket) {
        let siteCode = bucket.campaign.site.code;
        if (['TH', 'TG'].indexOf(siteCode) > -1) {
          return `${bucket.campaign.site.code}.${bucket.campaign.year}.${bucket.context.area.code}.${bucket.num}`
        } else {
          return `${bucket.campaign.site.code}.${bucket.campaign.year}.${bucket.type}.${bucket.num}`
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
      pagination: {
        handler (value, oldValue) {
          if (value !== oldValue) {
            this.fetch()
          }
        },
        deep: true
      },
      searchCriteria: {
        handler (value, oldValue) {
          if (value !== oldValue) {
            this.fetch()
          }
        },
        deep: true
      },
      reload (flag) {
        if (flag) {
          this.fetch()
        }
      }
    }
  }
</script>
