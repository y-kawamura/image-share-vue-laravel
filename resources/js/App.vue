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
import { INTERNAL_SERVER_ERROR } from './util';
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
    ...mapActions('error', ['setCode'])
  },
  watch: {
    code: {
      handler(val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push({ name: 'SystemError' });
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
