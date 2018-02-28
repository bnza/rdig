<template>
    <div>
        <data-item
            :table__="$route.params.table"
            :id__="$route.params.id"
            :uuidMxRegister="true"
            @setChildList="setChildList"
        />
        <data-list
            ref="childList"
            v-if="childList"
            v-bind:table__="childList"
            v-bind:parent__="parent"
            :uuidMxRegister="true"
            @setChildList="setChildList"
        />
    </div>
</template>

<script>
  import DataItem from './DataItem'
  import DataList from './DataList'
  import UuidMx from '../mixins/UuidMx'

  export default {
    name: 'the-data-item',
    components: {
      DataItem,
      DataList
    },
    mixins: [
      UuidMx
    ],
    data () {
      return {
        childList: ''
      }
    },
    computed: {
      parent () {
        return {
          table: this.$route.params.table,
          id:  this.$route.params.id
        }
      }
    },
    methods: {
      /**
       *
       * @param string
       */
      setChildList (table) {
        this.childList = table
      }
    }
  }
</script>