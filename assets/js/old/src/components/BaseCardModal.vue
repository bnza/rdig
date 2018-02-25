<template>
    <base-modal v-bind:active="active" v-on:close="$emit('close')">
        <div class="modal-card">
            <header class="modal-card-head">
                <slot name="header">
                    <p class="modal-card-title">{{title}}</p>
                    <button class="delete" aria-label="close" v-on:click="$emit('close')"></button>
                </slot>
            </header>
            <section class="modal-card-body">
                <slot />
            </section>
            <footer class="modal-card-foot">
                <slot name="footer"/>
            </footer>
        </div>
    </base-modal>
</template>

<script>
  import BaseModal from './BaseModal'
  export default {
    name: "base-card-modal",
    components: {
      BaseModal
    },
    props: {
      active: {
        type: Boolean,
        required: true
      },
      title: {
        type: String,
        required: true
      }
    }
  }
</script>

<style scoped>

</style>