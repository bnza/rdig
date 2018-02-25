<template>
    <th>
        <!-- TODO check authorization -->
        <a
            v-if="true"
            title="Delete item"
            class="has-text-danger"
            v-on:click="$listeners.openDeleteModal(value)"
        >
            <i class="fa fa-minus-square"></i>
        </a>
    </th>
</template>

<script>
  import BaseTableDataCell from './BaseTableDataCell'

  export default {
    name: 'open-delete-modal-table-data-cell',
    extends: BaseTableDataCell
  }
</script>