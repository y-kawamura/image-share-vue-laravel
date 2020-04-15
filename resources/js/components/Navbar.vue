<template>
  <nav class="navbar navbar-expand-sm navbar-light bg-light">
    <RouterLink class="navbar-brand" to="/">
      ImageShare
    </RouterLink>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul v-if="isLoggedIn" class="navbar-nav ml-auto">
        <li class="nav-item mr-2">
          <button @click="isShowForm = true" class="btn btn-outline-secondary">
            Submit a photo
          </button>
          <PhotoForm @close="isShowForm = false" :showForm="isShowForm" />
        </li>
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbarDropdown"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{ username }}
          </a>
          <div
            class="dropdown-menu dropdown-menu-right"
            aria-labelledby="navbarDropdown"
          >
            <span @click="logout" class="dropdown-item">Logout</span>
          </div>
        </li>
      </ul>
      <ul v-else class="navbar-nav ml-auto">
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
      </ul>
    </div>
  </nav>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';
import PhotoForm from './PhotoForm';

export default {
  components: {
    PhotoForm
  },
  data() {
    return {
      isShowForm: false
    };
  },
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
