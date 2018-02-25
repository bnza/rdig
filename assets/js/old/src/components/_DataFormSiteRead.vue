<template>
    <div>
        <form v-if="formData">
            <FormFieldHorizontal label="Code">
                <input class="input is-static" type="email" v-model="formData.code" readonly>
            </FormFieldHorizontal>
            <FormFieldHorizontal label="Name">
                <input class="input is-static" type="email" v-model="formData.name" readonly>
            </FormFieldHorizontal>
            <DataFormButtonGroup
                v-on:back="back"
                v-on:cancel="hideDeleteModal"
                v-on:showDeleteModal="showDeleteModal"
            />
        </form>
    </div>
</template>

<script>
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import DataFormMixin from '../mixins/DataFormMixin'

  export default {
    mixins: [
      PathHelperMixin,
      DataFormMixin
    ],
    created () {
      this.readData()
    },
    name: "DataFormSiteRead"
  }
</script>

<style scoped>

</style>