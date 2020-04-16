<template>
  <div class="row">
    <div
      class="col-6 col-md-4 col-xl-3"
      v-for="photo in photos"
      :key="photo.id"
    >
      <Photo :item="photo" />
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import { OK } from '../util';
import Photo from '../components/Photo.vue';

export default {
  components: {
    Photo
  },
  data() {
    return {
      photos: []
    };
  },
  methods: {
    ...mapActions('error', ['setCode']),
    async fetchPhotos() {
      const response = await axios.get('/api/photos');

      if (response.status !== OK) {
        this.setCode(response.status);
        return;
      }

      this.photos = response.data.data;
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
