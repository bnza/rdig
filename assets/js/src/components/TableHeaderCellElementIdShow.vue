<template>
    <th>
        <router-link
            v-bind:to="getItemPath(id)"
            title="Show item"
        >
            <i class="fa fa-arrow-right"></i>
        </router-link>
    </th>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'

  export default {
    mixins: [
      PathHelperMixin,
    ],
    props: ['id'],
    name: 'TableHeaderCellElementIdShow'
  }
</script>

<style scoped>

</style>