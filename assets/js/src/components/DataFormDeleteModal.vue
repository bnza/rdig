<template>
    <div class="modal is-active">
        <div
            class="modal-background"
            v-on:click="cancel"
        ></div>
        <div class="modal-content">
            <article class="message is-warning">
                <div class="message-header">
                    <p>Delete</p>
                    <button class="delete" aria-label="delete" v-on:click="cancel"></button>
                </div>
                <div class="message-body">
                    Do you really want delete this item from table <strong>{{tableName}}</strong>?<br/>
                    This action cannot be undone
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
  export default {
    props: ['tableName', 'id'],
    methods: {
      cancel: function () {
        this.$emit('cancel')
      },
      deleteEntity: function () {
        this.$emit('deleteEntity')
      }
    },
    name: 'DataFormDelete',
  }
</script>

<style scoped>

</style>