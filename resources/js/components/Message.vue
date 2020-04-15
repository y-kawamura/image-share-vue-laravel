<template>
  <div v-show="content" class="alert alert-success">
    {{ content }}
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  computed: {
    ...mapState('message', ['content'])
  }
};
</script>

<style></style>
