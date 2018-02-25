<template>
    <thead>
    <slot name="commands">
        <command-table-header-row
            v-bind:uuid="uuid"
        >
            <base-icon-router-link
                v-bind:path="createPath"
                icon="fa-plus-square"
                title="Add element"
            />
        </command-table-header-row>
    </slot>
    <base-table-header-row
        v-bind="$props"
    >
    </base-table-header-row>
    </thead>
</template>

<script>
  import BaseIconRouterLink from './BaseIconRouterLink'
  import BaseTableHeaderRow from "./BaseTableHeaderRow"
  import CommandTableHeaderRow from './CommandTableHeaderRow'

  export default {
    name: "base-table-header",
    components: {
      BaseTableHeaderRow,
      CommandTableHeaderRow,
      BaseIconRouterLink
    },
    props: {
      uuid: {
        type: Number,
        required: true
      },
      createPath: {
        type: String,
        required: true
      }
    }
  }
</script>