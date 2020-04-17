<template>
  <div>
    <div class="row">
      <div
        class="col-6 col-md-4 col-xl-3 my-3"
        v-for="photo in photos"
        :key="photo.id"
      >
        <Photo :item="photo" />
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
import { mapActions } from 'vuex';
import { OK } from '../util';
import Photo from '../components/Photo.vue';
import Pagination from '../components/Pagination.vue';

export default {
  components: {
    Photo,
    Pagination
  },
  data() {
    return {
      photos: [],
      currentPage: 1,
      lastPage: 1
    };
  },
  props: {
    page: {
      type: Number,
      default: 1
    }
  },
  methods: {
    ...mapActions('error', ['setCode']),
    async fetchPhotos() {
      const response = await axios.get(`/api/photos/?page=${this.page}`);

      if (response.status !== OK) {
        this.setCode(response.status);
        return;
      }

      this.photos = response.data.data;
      this.currentPage = response.data.current_page;
      this.lastPage = response.data.last_page;
    }
  },
  watch: {
    $route: {
      async handler() {
        await this.fetchPhotos();
      },
      immediate: true
    }
  }
};
</script>

<style></style>
