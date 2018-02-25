<template>
    <td>
        {{value}}
    </td>
</template>

<script>
  export default {
    props: {
      value: {
        required: true
      }
    },
    name: "base-table-data-cell",
  }
</script>