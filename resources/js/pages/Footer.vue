<template>
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item">
                <router-link to="/" class="nav-link px-2 text-body-secondary">Home</router-link>
            </li>
            <li class="nav-item">
                <router-link to="/login" class="nav-link px-2 text-body-secondary">Login</router-link>
            </li>
            <li class="nav-item">
                <router-link to="/register" class="nav-link px-2 text-body-secondary">Register</router-link>
            </li>
        </ul>
        <p class="text-center text-body-secondary">&copy; 2023 Company, Inc</p>
    </footer>
</template>

<script>
export default {
    name: "Footer"
}
</script>

<style scoped>

</style>
