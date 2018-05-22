<script>
  import RoutingMx from '../mixins/RoutingMx'
  import DataMx from '../mixins/DataMx'
  import {debounce} from '../util'

  export default {
    name: 'base-search-data-form',
    mixins: [
      DataMx,
      RoutingMx
    ],
    props: {
      searchCriteria__: {
        type: Object
      }
    },
    data () {
      return {
        search_: {}
      }
    },
    computed: {
      operators() {
        return {
          text: [
            {
              symbol: '',
              value: ''
            },
            {
              symbol: '=',
              value: 'eq',
            },
            {
              symbol: '≠',
              value: 'neq'
            },
            {
              symbol: '<',
              value: 'lt'
            },
            {
              symbol: '>',
              value: 'gt'
            },
            {
              symbol: 'LIKE',
              value: 'like'
            },
            {
              symbol: 'NOT LIKE',
              value: 'notLike'
            },
            {
              symbol: 'IS NULL',
              value: 'isNull'
            },
            {
              symbol: 'IS NOT NULL',
              value: 'isNotNull'
            },
          ],
          number: [
            {
              symbol: '',
              value: ''
            },
            {
              symbol: '=',
              value: 'eq',
            },
            {
              symbol: '≠',
              value: 'neq'
            },
            {
              symbol: '<',
              value: 'lt'
            },
            {
              symbol: '>',
              value: 'gt'
            },
            {
              symbol: 'IS NULL',
              value: 'isNull'
            },
            {
              symbol: 'IS NOT NULL',
              value: 'isNotNull'
            },
          ],
          boolean: [
            {
              symbol: '',
              value: ''
            },
            {
              symbol: 'IS NULL',
              value: 'isNull'
            },
            {
              symbol: '=',
              value: 'eq',
            },
          ]
        }
      },
      search() {
        let search = {}
        for (let criterium in this.search_) {
          if (this.search_.hasOwnProperty(criterium)
            && this.search_[criterium].op
          ) {
            search[criterium] = JSON.parse(JSON.stringify(this.search_[criterium]))
          }
        }
        return Object.keys(search).length > 0 ? search : undefined
      }
    },
    watch: {
      search (value) {
        this.$emit('sync', value)
      }
    },
    methods: {
      clear () {
        this.search_ = JSON.parse(JSON.stringify(this.defaultSearch))
      },
      toggleGroupsVisibility (group) {
        this.groupsVisibility[group] = !this.groupsVisibility[group]
      },
      getVisibilityIcon (group) {
        return this.groupsVisibility[group] ? 'expand_more' : 'expand_less'
      }
    },
    created () {
      // defaultSearch MUST be implemented in inherited classes
      let search = JSON.parse(JSON.stringify(this.defaultSearch))
      if (this.searchCriteria__) {
        for (let key in search) {
          if (this.searchCriteria__.hasOwnProperty(key)) {
            search[key] = this.searchCriteria__[key]
          }
        }
      }
      this.search_ = search
    }
  }
</script>

<style scoped lang="scss">
    .label >>> input:disabled {
        font-weight: bold;
        color: #000000;
    }
</style>