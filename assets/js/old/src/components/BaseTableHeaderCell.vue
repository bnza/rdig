<template>
    <th>
        {{label}}
    </th>
</template>

<script>
  import {mapGetters} from 'vuex'
  export default {
    props: {
      uuid: {
        type: Number,
        required: true
      },
      columnKey: {
        required: true,
        type: String
      }
    },
    name: "base-table-header-cell",
    computed: {
      label: function () {
        return this._labelGetterFn(this.uuid, this.columnKey)
      },
      field: function () {
        return this._fieldGetterFn(this.uuid, this.columnKey)
      },
      ...mapGetters('components/tables', {
        _labelGetterFn: 'label',
        _fieldGetterFn: 'field'
      })
    }
  }
</script>