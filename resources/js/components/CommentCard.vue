<template>
  <div style="background-color:#ecf0f1;">
    <p class="mb-1">{{ comment.content }}</p>
    <div class="d-flex w-100 justify-content-between text-muted">
      <small>{{ comment.author.name }}</small>
      <small>{{ sinceTime }}</small>
    </div>
  </div>
</template>

<script>
import * as moment from 'moment';

export default {
  props: {
    comment: {
      type: Object,
      required: true
    }
  },
  computed: {
    sinceTime() {
      return moment(this.comment.created_at).fromNow();
    }
  }
};
</script>

<style></style>
