<template>
    <th>
       <a v-on:click="showDeleteModal">
           <i class="has-text-danger fa fa-minus-circle"></i>
       </a>
    </th>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'

  export default {
    props: ['id'],
    mixins: [
      PathHelperMixin,
    ],
    methods: {
      showDeleteModal: function () {
        console.log(id)
      }
    },
    name: 'TableHeaderCellElementIdShow'
  }
</script>