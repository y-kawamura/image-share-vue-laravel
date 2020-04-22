<template>
  <div class="card w-100 photo-card">
    <img
      class="card-img-top"
      :src="photo.url"
      :alt="`Photo by ${photo.owner.name}`"
    />
    <RouterLink
      class="photo-overlay"
      :to="{ name: 'PhotoDetail', params: { id: photo.id } }"
    >
      <div class="photo-items">
        <span class="photo-user">
          {{ photo.owner.name }}
        </span>
        <div>
          <like-button
            :likesCount="photo.likes_count"
            :likedByUser="photo.liked_by_user"
            @clickLike="onClickLike"
          />
          <download-button :id="photo.id" />
        </div>
      </div>
    </RouterLink>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import LikeButton from './LikeButton.vue';
import DownloadButton from './DownloadButton.vue';

export default {
  props: {
    photo: {
      type: Object,
      required: true
    }
  },
  components: {
    LikeButton,
    DownloadButton
  },
  computed: {
    ...mapGetters('auth', ['isLoggedIn'])
  },
  methods: {
    ...mapActions('photo', ['like', 'unlike']),
    onClickLike() {
      if (!this.isLoggedIn) {
        alert('Please login');
        return;
      }
      if (this.photo.liked_by_user) {
        this.unlike(this.photo.id);
      } else {
        this.like(this.photo.id);
      }
    }
  }
};
</script>

<style scoped>
.photo-card:hover .photo-overlay {
  opacity: 0.8;
}

.photo-overlay {
  position: absolute;
  height: 100%;
  width: 100%;
  bottom: 0;
  opacity: 0;
  transition: 0.3s ease;
}

.photo-items {
  position: absolute;
  bottom: 0;
  background-color: #eee;
  height: 50px;
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 1rem;
}

.photo-user {
  color: #626262;
}
</style>
