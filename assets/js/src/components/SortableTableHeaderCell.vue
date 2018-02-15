<template>
    <th>
        {{label}}
        <a v-on:click="sort" v-bind:class="{'has-text-grey-lighter':!isCurrentSort}">
            <i v-if="label" class="fa fa-sort-down fa-pull-right" v-bind:class="sortOrderClass"></i>
        </a>
    </th>
</template>

<script>
  import BaseTableHeaderCell from './BaseTableHeaderCell'

  export default {
    name: 'sortable-table-header-cell',
    extends: BaseTableHeaderCell,
    data: function() {
      return {
        sortOrder: 'ASC',
      }
    },
    computed: {
      sortCriteria: function () {
        return this.$store.getters['components/tables/sortCriteria'](this.uuid)
      },
      isCurrentSort: function () {
        return this.sortCriteria.hasOwnProperty(this.field)
      },
      sortOrderClass: function () {
        let className = 'fa-sort-down'
        if (this.isCurrentSort) {
          className = this.sortCriteria[this.columnKey] === 'ASC' ? 'fa-sort-down' : 'fa-sort-up'
        }
        return className
      }
    },
    methods: {
      sort: function () {
        if (this.isCurrentSort) {
          if (this.sortOrder === 'ASC') {
            this.sortOrder = 'DESC'
          } else {
            this.sortOrder = 'ASC'
          }
        } else {
          this.sortOrder = 'ASC'
        }
        let sortCriteria = {}
        sortCriteria[this.field] = this.sortOrder
        this.$store.dispatch('components/tables/setSortCriteria', {
          criteria: sortCriteria,
          uuid: this.uuid
        })
      }
    }
  }
</script>

<style scoped>

</style>