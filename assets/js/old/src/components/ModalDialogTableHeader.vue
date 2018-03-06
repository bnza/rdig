<template>
    <thead>
    <command-table-header-row
        v-bind:uuid="uuid"
    >
        <!-- TODO check auth -->
        <a
            v-if="true"
            title="Add element"
            v-on:click="$listeners.openAddModal(value)"
        >
            <span class="icon has-text-success is-pulled-right">
                <i class="fa fa-2x fa-plus-square"></i>
            </span>

        </a>
    </command-table-header-row>

    <base-table-header-row
        v-bind:uuid="uuid"
    >
    </base-table-header-row>
    </thead>
</template>

<script>
  import BaseTableHeader from './BaseTableHeader'
  import BaseTableHeaderRow from './BaseTableHeaderRow'
  import CommandTableHeaderRow from '/.CommandTableHeaderRow'

  export default {
    name: "modal-dialog-table-header",
    extends: BaseTableHeader,
    components: {
      BaseTableHeaderRow,
      CommandTableHeaderRow
    }
  }
</script>