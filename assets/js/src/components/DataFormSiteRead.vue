<template>
    <div v-if="formData">
        <form>
            <FormFieldHorizontal label="Code">
                <input class="input is-static" type="email" v-model="formData.code" readonly>
            </FormFieldHorizontal>
            <FormFieldHorizontal label="Name">
                <input class="input is-static" type="email" v-model="formData.name" readonly>
            </FormFieldHorizontal>
            <DataFormButtonGroup v-bind:tableName="tableName" v-bind:id="id"/>
        </form>
    </div>
</template>

<script>
  import FormFieldHorizontal from './FormFieldHorizontal'
  import DataFormButtonGroup from './DataFormButtonGroup'
  import DataFormMixin from '../mixins/DataFormMixin'

  export default {
    components: {
      FormFieldHorizontal,
      DataFormButtonGroup
    },
    mixins: [
      DataFormMixin
    ],
    props: ['tableName', 'id'],
    created () {
      this.readData()
    },
    name: "DataFormSiteRead"
  }
</script>

<style scoped>

</style>