<template>
  <nav>
    <ul class="pagination">
      <li class="page-item" :class="{ disabled: isFirstPage }">
        <RouterLink
          class="page-link"
          :to="{ name: 'PhotoList', query: { page: currentPage - 1 } }"
        >
          Previous</RouterLink
        >
      </li>
      <li class="page-item" :class="{ disabled: isLastPage }">
        <RouterLink
          class="page-link"
          :to="{ name: 'PhotoList', query: { page: currentPage + 1 } }"
        >
          Next</RouterLink
        >
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: {
    currentPage: {
      type: Number,
      required: true
    },
    lastPage: {
      type: Number,
      required: true
    }
  },
  computed: {
    isFirstPage() {
      return this.currentPage === 1;
    },
    isLastPage() {
      return this.currentPage === this.lastPage;
    }
  }
};
</script>

<style></style>
