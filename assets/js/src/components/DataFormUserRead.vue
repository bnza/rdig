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
            v-bind:tableName="tableName"
            v-bind:id="id"
            v-bind:routePrefix="routePrefix"
            v-bind:action="action"
            v-bind:username="formData.username"

            v-on:back="back"
            v-on:cancel="hideDeleteModal"
            v-on:showDeleteModal="showDeleteModal"
        />
    </form>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import DataFormMixin from '../mixins/DataFormMixin'
  import DataFormUserButtonGroup from './DataFormUserButtonGroup'

  export default {
    components: {
      DataFormUserButtonGroup
    },
    mixins: [
      PathHelperMixin,
      DataFormMixin
    ],
    props: ['routePrefix','tableName', 'id', 'action'],
    created () {
      this.readData()
    },
    name: "DataFormUserRead"
  }
</script>

<style scoped>

</style>