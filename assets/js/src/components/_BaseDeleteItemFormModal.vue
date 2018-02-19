<template>
    <base-modal v-bind:active="active" v-on:close="$emit('close')">
        Do you really want delete this item from table <strong>{{$_route.table}}</strong>?<br/><br/>
        This action <span class="has-text-danger">cannot</span> be undone<br/><br/>
        <div class="buttons">
                        <span class="button is-text" v-on:click="cancel">
                            Back
                        </span>
            <span class="button is-danger" v-on:click="deleteEntity">Delete</span>
        </div>
    </base-modal>
</template>

<script>
  import BaseModal from './BaseModal'
  export default {
    name: "base-delete-item-form-modal",
    components: {
      BaseModal
    }
  }
</script>

<style scoped>

</style>