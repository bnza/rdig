<template>
    <th>
       <a v-on:click="$emit('showDeleteModal')">
           <i class="has-text-danger fa fa-minus-circle"></i>
       </a>
    </th>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'

  export default {
    mixins: [
      PathHelperMixin,
    ],
    name: 'TableHeaderCellElementIdShow'
  }
</script>