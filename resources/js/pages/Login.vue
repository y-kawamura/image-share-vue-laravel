<template>
  <div class="p-5">
    <h1>Login</h1>
    <!-- error message -->
    <div v-if="loginErrorMessages" class="alert alert-danger">
      <div v-if="loginErrorMessages.email">
        <p
          class="p-0 m-0"
          v-for="message in loginErrorMessages.email"
          :key="message"
        >
          {{ message }}
        </p>
      </div>
      <div v-if="loginErrorMessages.password">
        <p
          class="p-0 m-0"
          v-for="message in loginErrorMessages.password"
          :key="message"
        >
          {{ message }}
        </p>
      </div>
    </div>
    <form @submit.prevent="onSubmit">
      <div class="form-group">
        <label for="email">Email address</label>
        <input
          type="email"
          class="form-control"
          id="email"
          v-model="user.email"
        />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          v-model="user.password"
        />
      </div>
      <button type="submit" class="btn btn-primary float-right">Login</button>
    </form>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
  data() {
    return {
      user: {
        email: '',
        password: ''
      }
    };
  },
  computed: {
    ...mapState('auth', ['apiStatus', 'loginErrorMessages'])
  },
  methods: {
    ...mapActions('auth', ['login', 'clearErrorMessages']),
    async onSubmit() {
      await this.login(this.user);

      if (this.apiStatus) {
        this.$router.push({ name: 'PhotoList' });
      }
    }
  },
  created() {
    this.clearErrorMessages();
  }
};
</script>

<style></style>
