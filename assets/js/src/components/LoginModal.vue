<template>
    <div class="modal is-active">
        <div
                class="modal-background"
                v-on:click="cancel"
        ></div>
        <div class="modal-content">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        Login
                    </p>
                </header>
                <div class="card-content">
                    <LoginModalForm v-on:cancel="cancel"></LoginModalForm>
                </div>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close" v-on:click="cancel"></button>
    </div>
</template>

<script>
  import LoginModalForm from "./LoginModalForm";
  export default {
    components: {LoginModalForm},
    name: "LoginModal",
    methods: {
      cancel: function () {
        this.$router.back()
      },
    }
  }
</script>

<style scoped>

</style>