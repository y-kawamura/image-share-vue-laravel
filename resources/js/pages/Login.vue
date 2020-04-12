<template>
  <div class="p-5">
    <h1>Login</h1>
    <form @submit.prevent="login">
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
export default {
  data() {
    return {
      user: {
        email: '',
        password: ''
      }
    };
  },
  methods: {
    login() {
      console.log(this.user);
    }
  }
};
</script>

<style></style>
