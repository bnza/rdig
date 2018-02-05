<template>
    <th>
        {{label}}
        <a v-on:click="sort" v-bind:class="{'has-text-grey-lighter':!isCurrentSort}">
            <i v-if="label" class="fa fa-sort-down fa-pull-right" v-bind:class="sortOrderClass"></i>
        </a>
    </th>
</template>

<script>
  export default {
    data: function() {
      return {
        sortOrder: 'ASC',
      }
    },
    props: [
      'label',
      'field',
      'sortCriteria'
    ],
    computed: {
      isCurrentSort: function () {
        return this.sortCriteria.field === this.field
      },
      sortOrderClass: function () {
        let className = 'fa-sort-down'
        if (this.isCurrentSort) {
          className = this.sortCriteria.order === 'ASC' ? 'fa-sort-down' : 'fa-sort-up'
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
        this.$emit('sort', { field: this.field, order: this.sortOrder })
      }
    },
    name: "DataTableRowCellHead"
  }
</script>

<style scoped>

</style>