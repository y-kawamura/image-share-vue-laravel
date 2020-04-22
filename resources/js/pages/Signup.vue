<template>
  <div class="p-5">
    <h1>Signup</h1>
    <!-- error message -->
    <div v-if="signupErrorMessages" class="alert alert-danger">
      <div v-if="signupErrorMessages.name">
        <p
          class="p-0 m-0"
          v-for="message in signupErrorMessages.name"
          :key="message"
        >
          {{ message }}
        </p>
      </div>
      <div v-if="signupErrorMessages.email">
        <p
          class="p-0 m-0"
          v-for="message in signupErrorMessages.email"
          :key="message"
        >
          {{ message }}
        </p>
      </div>
      <div v-if="signupErrorMessages.password">
        <p
          class="p-0 m-0"
          v-for="message in signupErrorMessages.password"
          :key="message"
        >
          {{ message }}
        </p>
      </div>
    </div>

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
import { mapState, mapActions } from 'vuex';

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
  computed: {
    ...mapState('auth', ['apiStatus', 'signupErrorMessages'])
  },
  methods: {
    ...mapActions('auth', ['signup', 'clearErrorMessages']),
    async onSubmit() {
      await this.signup(this.user);
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
