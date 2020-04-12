<template>
  <div class="p-5">
    <h1>Signup</h1>
    <form @submit.prevent="signup">
      <div class="form-group">
        <label for="username">User Name</label>
        <input
          type="text"
          class="form-control"
          id="username"
          v-model="user.username"
        />
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
        <label for="confirmPassword">Confirm Password</label>
        <input
          type="password"
          class="form-control"
          id="confirmPassword"
          v-model="user.confirmPassword"
        />
      </div>
      <button type="submit" class="btn btn-primary float-right">Sign Up</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        username: '',
        email: '',
        password: '',
        confirmPassword: ''
      }
    };
  },
  methods: {
    signup() {
      console.log(this.user);
    }
  }
};
</script>

<style></style>
