<template>
    <tr>
        <td v-bind:colspan="$store.getters['components/tables/tableColumnsNum'](uuid)">
            <slot />
        </td>
    </tr>
    
</template>

<script>
  export default {
    name: "command-table-header-row",
    props: {
      uuid: {
        type: Number,
        required: true
      }
    },
  }
</script>

<style scoped>
    tr > td {
        border-bottom: 0;
    }
</style>