<template>
    <form v-if="formData">
        <FormFieldHorizontal label="Code">
            <input class="input is-static" type="email" v-model="formData.code" readonly>
        </FormFieldHorizontal>
        <FormFieldHorizontal label="Name">
            <input class="input is-static" type="email" v-model="formData.name" readonly>
        </FormFieldHorizontal>
        <DataFormButtonGroup
            v-bind:tableName="tableName"
            v-bind:id="id"
            v-on:back="back"
            v-on:cancel="hideDeleteModal"
            v-on:showDeleteModal="showDeleteModal"
        />
    </form>
</template>

<script>
  import FormFieldHorizontal from './FormFieldHorizontal'
  import DataFormButtonGroup from './DataFormButtonGroup'
  import DataFormMixin from '../mixins/DataFormMixin'

  export default {
    components: {
      FormFieldHorizontal,
      DataFormButtonGroup,
    },
    mixins: [
      DataFormMixin
    ],
    props: ['tableName', 'id', 'action'],
    created () {
      this.readData()
    },
    name: "DataFormSiteRead"
  }
</script>

<style scoped>

</style>