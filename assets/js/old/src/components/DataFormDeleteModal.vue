<template>
    <base-card-modal title="Delete item" v-bind:active="active" v-on:close="$emit('close')">
        Do you really want delete this item from table <strong>{{table}}</strong>?<br/><br/>
        This action <span class="has-text-danger"><strong>cannot</strong></span> be undone<br/><br/>
        <div class="buttons" slot="footer">
            <button class="button is-text" v-on:click="$emit('close')">
                Back
            </button>
            <base-form-button
                class="is-danger"
                label="Delete"
                v-bind:isRequestPending="isRequestPending"
                v-on:click="$emit('delete')"
            />
        </div>
    </base-card-modal>
</template>

<script>
  import BaseCardModal from './BaseCardModal'
  import BaseFormButton from './BaseFormButton'
  export default {
    name: "data-form-delete-modal",
    props: {
      active: {
        type: Boolean,
        required: true
      },
      table: {
        type: String,
        required: true
      },
      isRequestPending: {
        type: Boolean,
        required: true
      }
    },
    components: {
      BaseCardModal,
      BaseFormButton
    }
  }
</script>

<style scoped>

</style>