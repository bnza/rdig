<template>
    <article>
        <h2 class="is-size-3">{{listTitle}}</h2>
        <component
            v-bind:is="tableComponent"
            v-bind:parent="parent"
            v-bind:route="route"
        />
    </article>
</template>

<script>
  import DataList from './DataList'
  export default {
    name: "child-data-list",
    extends: DataList,
    props: {
      parent: {
        type: Object,
        required: true,
        validator: function (value) {
          return value.hasOwnProperty('table') && value.hasOwnProperty('id')
        }
      },
      title: {
        type: String
      }
    },
    computed: {
      listTitle: function () {
        return this.title || this.$_route.table
      }
    }

  }
</script>

<style scoped>
    article {
        margin-top: 3rem;
    }
</style>