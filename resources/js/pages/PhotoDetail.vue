<template>
  <div class="row">
    <div v-if="photo" class="col-12 col-md-6">
      <img
        class="w-100"
        :src="photo.url"
        :alt="`the image posted by ${photo.owner.name}`"
      />
      <div class="d-flex justify-content-between align-items-center px-2">
        <span>Posted by {{ photo.owner.name }}</span>
        <div>
          <like-button :like="10" />
          <download-button :id="id" />
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6">
      <h4>Comments</h4>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import { OK } from '../util';
import LikeButton from '../components/LikeButton.vue';
import DownloadButton from '../components/DownloadButton.vue';

export default {
  data() {
    return {
      photo: null
    };
  },
  props: {
    id: {
      type: String,
      required: true
    }
  },
  components: {
    LikeButton,
    DownloadButton
  },
  methods: {
    ...mapActions('error', ['setCode']),
    async fetchPhoto() {
      const response = await axios.get(`/api/photos/${this.id}`);

      if (response.status !== OK) {
        this.setCode(response.status);
        return;
      }

      this.photo = response.data;
    }
  },
  watch: {
    $rotue: {
      async handler() {
        await this.fetchPhoto();
      },
      immediate: true
    }
  }
};
</script>

<style></style>
