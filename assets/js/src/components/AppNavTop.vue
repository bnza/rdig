<template>
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <router-link to="/" class="navbar-item">
                r<strong>D</strong>ig
            </router-link>

            <button class="button navbar-burger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
</template>

<script>
  export default {
    name: "app-nav-top"
  }
</script>

<style scoped>

</style>