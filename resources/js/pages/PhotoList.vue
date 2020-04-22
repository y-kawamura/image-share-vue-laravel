<template>
  <div>
    <div class="row">
      <div
        class="col-6 col-md-4 col-xl-3 my-3"
        v-for="photo in photos"
        :key="photo.id"
      >
        <Photo :photo="photo" />
      </div>
    </div>
    <div class="row">
      <Pagination
        class="my-4 mx-auto"
        :current-page="currentPage"
        :last-page="lastPage"
      />
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import Photo from '../components/Photo.vue';
import Pagination from '../components/Pagination.vue';

export default {
  components: {
    Photo,
    Pagination
  },
  props: {
    page: {
      type: Number,
      default: 1
    }
  },
  computed: {
    ...mapState('photo', ['photos', 'currentPage', 'lastPage'])
  },
  methods: {
    ...mapActions('photo', ['fetchPhotos'])
  },
  watch: {
    $route: {
      async handler() {
        await this.fetchPhotos(this.page);
      },
      immediate: true
    }
  }
};
</script>

<style></style>
