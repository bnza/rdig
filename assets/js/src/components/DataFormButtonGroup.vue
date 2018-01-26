<template>
    <div class="field is-horizontal">
        <div class="field-label">
            <!-- Left empty for spacing -->
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <div class="buttons">
                        <span class="button is-text" v-on:click="back">
                            Back
                        </span>
                        <span class="button is-success" v-on:click="updateEntity">Edit</span>
                        <span class="button is-danger" v-on:click="deleteEntity">Delete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    props:['tableName', 'id'],
    methods: {
      back: function () {
        this.$router.back()
      },
      updateEntity: function () {
        this.$router.replace({ name: 'data_element', params: { tableName: this.tableName, action: 'update', id: this.id }})
      },
      deleteEntity: function () {
        this.$router.replace({ name: 'data_element', params: { tableName: this.tableName, action: 'delete', id: this.id }})
      },
    },
    name: "DataFormButtonGroup"
  }
</script>

<style scoped>

</style>