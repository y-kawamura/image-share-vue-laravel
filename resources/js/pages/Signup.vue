<template>
  <div class="p-5">
    <h1>Signup</h1>
    <form @submit.prevent="onSubmit">
      <div class="form-group">
        <label for="name">User Name</label>
        <input type="text" class="form-control" id="name" v-model="user.name" />
      </div>
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
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input
          type="password"
          class="form-control"
          id="password_confirmation"
          v-model="user.password_confirmation"
        />
      </div>
      <button type="submit" class="btn btn-primary float-right">Sign Up</button>
    </form>
  </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  data() {
    return {
      user: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    };
  },
  methods: {
    ...mapActions('auth', ['signup']),
    async onSubmit() {
      await this.signup(this.user);
      this.$router.push('/');
    }
  }
};
</script>

<style></style>
