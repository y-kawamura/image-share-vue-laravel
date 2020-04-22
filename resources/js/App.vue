<template>
  <div>
    <header class="py-2">
      <Navbar />
    </header>
    <main>
      <div class="container">
        <Message />
        <RouterView />
      </div>
    </main>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import { INTERNAL_SERVER_ERROR, NOT_FOUND, UNAUTHORIZED } from './util';
import Navbar from './components/Navbar.vue';
import Message from './components/Message.vue';

export default {
  components: {
    Navbar,
    Message
  },
  computed: {
    ...mapState('error', ['code'])
  },
  methods: {
    ...mapActions('error', ['setCode']),
    ...mapActions('auth', ['setUser'])
  },
  watch: {
    code: {
      async handler(val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push({ name: 'SystemError' });
        } else if (val === UNAUTHORIZED) {
          await axios.get('/api/refresh-token');
          this.setUser(null);
          this.$router.push({ name: 'Login' });
        } else if (val === NOT_FOUND) {
          this.$router.push({ name: 'NotFound' });
        }
      },
      immediate: true
    },
    $route() {
      this.setCode(null);
    }
  }
};
</script>

<style></style>
