<template>
    <form v-if="formData">
        <FormFieldHorizontal label="Username">
            <input class="input is-static" type="text" v-model="formData.username" readonly>
        </FormFieldHorizontal>
        <FormFieldHorizontal label="Password">
            <input class="input is-static" type="password" v-model="formData.password" readonly>
        </FormFieldHorizontal>
        <FormFieldHorizontal label="Roles">
            <input class="input is-static" type="text" v-model="formData.roles" readonly>
        </FormFieldHorizontal>
        <DataFormUserButtonGroup
            v-bind:username="formData.username"
            v-on:back="back"
            v-on:cancel="hideDeleteModal"
            v-on:showDeleteModal="showDeleteModal"
        />
        <DataList
            v-bind:parent="{table: $_route.table, id: $_route.id}"
            v-bind:route="{table: 'user-allowed-sites'}"
        ></DataList>
    </form>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import DataFormMixin from '../mixins/DataFormMixin'
  import DataFormUserButtonGroup from './DataFormUserButtonGroup'
  import DataList from './DataList'

  export default {
    components: {
      DataFormUserButtonGroup,
      DataList
    },
    mixins: [
      PathHelperMixin,
      DataFormMixin
    ],
    created () {
      this.readData()
    },
    name: "DataFormUserRead"
  }
</script>

<style scoped>

</style>