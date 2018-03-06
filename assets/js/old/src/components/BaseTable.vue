<template>
    <table class="table is-striped is-hoverable is-fullwidth">
        <caption>
            <section>

            </section>
        </caption>
        <component
            v-if="uuid"
            ref="header"
            v-bind:is="tableHeaderComponent"
            v-bind:createPath="createPath"
            v-bind:uuid="uuid"
            v-bind="$props"
            v-on="$listeners">
        </component>
        <component
            v-if="uuid"
            ref="body"
            v-bind:uuid="uuid"
            v-bind:is="tableBodyComponent"
            v-bind:tableData="tableData"
            v-bind="$props"
            v-on="$listeners"
        >
        </component>
    </table>
</template>

<script>
  import DataTableMixin from '../mixins/DataTableMixin'
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import DataFormDeleteModal from './DataFormDeleteModal'

  export default {
    name: "base-table",
    components: {
      DataFormDeleteModal,
      BaseTableBody: () => import(
        /* webpackChunkName: "BaseTableBody" */
        './BaseTableBody'
        ),
      BaseTableHeader: () => import(
        /* webpackChunkName: "BaseTableHeader" */
        './BaseTableHeader'
        ),
    },
    mixins: [
      PathHelperMixin,
      DataTableMixin
    ],
    props: {
      tableConfigObject: {
        type: Object,
        required: true
      }
    },
    data: function () {
      return {
        uuid: false,
        isDeleteModalActive: false
      }
    },
    computed: {
      sortCriteria: function () {
        return this.uuid ? this.$store.getters['components/tables/sortCriteria'](this.uuid) : null
      },
      tableBodyComponent: function () {
        return this.uuid ? this.$store.getters['components/tables/tableBodyComponent'](this.uuid) : null
      },
      tableHeaderComponent: function () {
        return this.uuid ? this.$store.getters['components/tables/tableHeaderComponent'](this.uuid) : null
      }
    },
    methods: {
      setUp: function () {
        this.$store.dispatch('components/tables/setConfig', {
          config: this.tableConfigObject,
          uuid: this.uuid
        })
      }
    },
    watch: {
      sortCriteria: function (value, oldValue) {
        if (value !== oldValue) {
          this.$_DataTableMixin_fetchData()
        }
      }
    },
    created: function () {
      let vm = this
      this.$store.dispatch('components/tables/add').then(
        function(uuid) {
          vm.uuid = uuid
          vm.setUp()
        }
      )
    },
    beforeDestroy: function () {
      this.$store.dispatch('components/tables/remove', this.uuid)
    }
  }
</script>