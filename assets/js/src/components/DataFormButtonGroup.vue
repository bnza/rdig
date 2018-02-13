<template>
    <div class="field is-horizontal">
        <div class="field-label">
            <!-- Left empty for spacing -->
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <div class="buttons">
                        <button class="button is-text" v-on:click="back">
                            Back
                        </button>
                        <button class="button is-success" v-on:click="updateEntity" v-bind:disabled="!authorize(updatePath)">Edit</button>
                        <button class="button is-danger" v-on:click="showDeleteModal" v-bind:disabled="!authorize(deletePath)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import AuthorizationHelperMixin from '../mixins/AuthorizationHelperMixin'
  import PathHelperMixin from '../mixins/PathHelperMixin'

  export default {
    mixins: [
      PathHelperMixin,
      AuthorizationHelperMixin
    ],
    methods: {
      back: function () {
        this.$emit('back')
      },
      updateEntity: function () {
        this.$router.replace(this.updatePath)
      },
      showDeleteModal: function () {
        this.$emit('showDeleteModal')
      },
    },
    name: "DataFormButtonGroup"
  }
</script>

<style scoped>

</style>