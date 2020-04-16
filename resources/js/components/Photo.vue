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
          <button class="btn photo-like mr-1">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              aria-hidden="true"
              focusable="false"
              width="1em"
              height="1em"
              style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
              preserveAspectRatio="xMidYMid meet"
              viewBox="0 0 512 512"
            >
              <path
                d="M256 448l-9-6c-42.78-28.57-96.91-60.86-137-108.32c-42.25-50-62.52-101.35-62-157C48.63 114.54 98.46 64 159.08 64c48.11 0 80.1 28 96.92 48.21C272.82 92 304.81 64 352.92 64c60.62 0 110.45 50.54 111.08 112.65c.56 55.68-19.71 107-62 157c-40.09 47.49-94.22 79.78-137 108.35z"
                fill="#626262"
              />
            </svg>
            12
          </button>
          <a
            :href="`/photos/${item.id}/download`"
            @click.stop
            class="photo-download"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              aria-hidden="true"
              focusable="false"
              width="1em"
              height="1em"
              style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
              preserveAspectRatio="xMidYMid meet"
              viewBox="0 0 512 512"
            >
              <path
                d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2c-60 5.7-112 35.88-112 98.4S70 336 136 336h56"
                fill="none"
                stroke="#626262"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="32"
              />
              <path
                fill="none"
                stroke="#626262"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="32"
                d="M192 400.1l64 63.9l64-63.9"
              />
              <path
                fill="none"
                stroke="#626262"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="32"
                d="M256 224v224.03"
              />
            </svg>
          </a>
        </div>
      </div>
    </RouterLink>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true
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
  height: 30%;
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 1rem;
}

.photo-user,
.photo-like,
.photo-download {
  color: #626262;
}

.photo-like:hover,
.photo-like:hover > svg path {
  color: #ed4c67;
  fill: #ed4c67;
}

.photo-download:hover > svg path {
  stroke: #3498db;
}
</style>
