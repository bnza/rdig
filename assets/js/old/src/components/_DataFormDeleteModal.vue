<template>
    <div class="modal is-active">
        <div
            class="modal-background"
            v-on:click="cancel"
        ></div>
        <div class="modal-content">
            <article class="message is-dark">
                <div class="message-header">
                    <p>Delete</p>
                    <button class="delete" aria-label="delete" v-on:click="cancel"></button>
                </div>
                <div class="message-body">
                    Do you really want delete this item from table <strong>{{$_route.table}}</strong>?<br/><br/>
                    This action <span class="has-text-danger">cannot</span> be undone<br/><br/>
                    <div class="buttons">
                        <span class="button is-text" v-on:click="cancel">
                            Back
                        </span>
                        <span class="button is-danger" v-on:click="deleteEntity">Delete</span>
                    </div>
                </div>
            </article>
        </div>
        <button class="modal-close is-large" aria-label="close" v-on:click="cancel"></button>
    </div>
</template>

<script>

  import PathHelperMixin from '../mixins/PathHelperMixin'

  export default {
    name: 'DataFormDelete',
    mixins: [
      PathHelperMixin
    ],
    methods: {
      cancel: function () {
        this.$emit('cancel')
      },
      deleteEntity: function () {
        this.$emit('deleteEntity')
      }
    },
  }
</script>

<style scoped>

</style>