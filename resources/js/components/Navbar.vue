<template>
  <nav class="navbar navbar-light bg-light">
    <RouterLink class="navbar-brand" to="/">
      ImageShare
    </RouterLink>
    <ul class="navbar-nav ml-auto">
      <!-- logged in -->
      <div v-if="isLoggedIn" class="d-flex">
        <li class="nav-item">
          <span class="d-block p-2"> {{ username }} </span>
        </li>
        <li class="nav-item">
          <button @click="logout" class="btn btn-outline-secondary">
            Logout
          </button>
        </li>
      </div>
      <!-- not logged in -->
      <div v-else class="d-flex">
        <li class="nav-item">
          <RouterLink class="nav-link p-2" to="/signup">
            SignUp
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link p-2" to="/login">
            Login
          </RouterLink>
        </li>
      </div>
    </ul>
  </nav>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';

export default {
  computed: {
    ...mapState('auth', ['apiStatus']),
    ...mapGetters('auth', ['isLoggedIn', 'username'])
  },
  methods: {
    ...mapActions('auth', { authLogout: 'logout' }),
    async logout() {
      await this.authLogout();
      if (this.apiStatus) {
        this.$router.push({ name: 'Login' });
      }
    }
  }
};
</script>

<style></style>
