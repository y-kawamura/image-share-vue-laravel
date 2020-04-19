<template>
  <div class="card w-100 photo-card">
    <img
      class="card-img-top"
      :src="item.url"
      :alt="`Photo by ${item.owner.name}`"
    />
    <RouterLink
      class="photo-overlay"
      :to="{ name: 'PhotoDetail', params: { id: item.id } }"
    >
      <div class="photo-items">
        <span class="photo-user">
          {{ item.owner.name }}
        </span>
        <div>
          <like-button :like="10" />
          <download-button :id="item.id" />
        </div>
      </div>
    </RouterLink>
  </div>
</template>

<script>
import LikeButton from './LikeButton.vue';
import DownloadButton from './DownloadButton.vue';

export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  components: {
    LikeButton,
    DownloadButton
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
