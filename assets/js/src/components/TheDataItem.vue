<template>
    <section>
        <item-data-panel
            ref="dataItem"
            :prefix__="$route.params.prefix"
            :table__="$route.params.table"
            :id__="$route.params.id"
            :uuidMxRegister="true"
            @setChildList="setChildList"
        />
        <list-data-panel
            ref="childList"
            v-if="childList"
            :prefix__="$route.params.prefix"
            :table__="childList"
            :parent__="parent"
            :uuidMxRegister="true"
            @setChildList="setChildList"
            v-on="$listeners"
        />
    </section>
</template>

<script>
  import ItemDataPanel from './ItemDataPanel'
  import ListDataPanel from './ListDataPanel'
  import UuidMx from '../mixins/UuidMx'

  export default {
    name: 'the-data-item',
    components: {
      ItemDataPanel,
      ListDataPanel
    },
    mixins: [
      UuidMx
    ],
    computed: {
      childList () {
        return this.$route.params.childTable || ''
      },
      dataFormComponent () {
        return this.$refs.dataItem.dataComponent
      },
      parent () {
        if (this.$route.params.childTable) {
          return {
            table: this.$route.params.table,
            id:  this.$route.params.id
          }
        }
      }
    },
    methods: {
      /**
       *
       * @param string
       */
      setChildList (table) {
        let path = table
          ? this.dataFormComponent.routingMxGetChildListPath(table)
          : this.dataFormComponent.routingMxItemPath

        this.$router.push(path)
      }
    }
  }
</script>