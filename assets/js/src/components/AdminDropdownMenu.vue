<template>
    <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
            Admin
        </a>

        <div class="navbar-dropdown">
            <router-link
                class="navbar-item"
                :to="{ name: 'data_list', params: { routePrefix: 'admin', tableName: 'user', action: 'read' }}"
            >
                <span class="icon has-text-info">
                    <i class="fa fa-users"></i>
                </span>
                Users
            </router-link>

        </div>
    </div>
    
</template>

<script>
  export default {
    name: "AdminDropDownMenu"
  }
</script>

<style scoped>

</style>