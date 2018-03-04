<template>
    <div>
        <data-item
            ref="dataItem"
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
    computed: {
      childList () {
        return this.$route.params.childTable || ''
      },
      dataFormComponent () {
        return this.$refs.dataItem.dataFormComponent
      },
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
        this.$router.push({
          path: this.dataFormComponent.pathMxGetChildListPath(table)
        })
      }
    }
  }
</script>