<template>
  <div v-if="photo" class="row">
    <div class="col-12 col-md-6">
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
    <!-- Comments -->
    <div class="col-12 col-md-6 mt-4 mt-md-0">
      <h4>Comments</h4>
      <div v-if="photo.comments.length > 0">
        <div
          v-for="comment in photo.comments"
          :key="comment.id"
          class="list-group"
        >
          <comment-card :comment="comment" class="list-group-item mb-1" />
        </div>
      </div>
      <div v-else>
        <p>No comments</p>
      </div>
      <form v-if="isLoggedIn" @submit.prevent="onSubmit" class="mt-2">
        <div class="form-group">
          <textarea
            id="comment"
            v-model="comment"
            class="form-control"
          ></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">
          Submit
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util';
import LikeButton from '../components/LikeButton.vue';
import DownloadButton from '../components/DownloadButton.vue';
import CommentCard from '../components/CommentCard.vue';

export default {
  data() {
    return {
      photo: null,
      comment: '',
      errors: null
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
    DownloadButton,
    CommentCard
  },
  computed: {
    ...mapGetters('auth', ['isLoggedIn'])
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
    },
    async addComment() {
      const response = await axios.post(
        `/api/photo/${this.photo.id}/comments`,
        {
          content: this.comment
        }
      );

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.errors = response.data.errors;
        return;
      }

      if (response.status !== CREATED) {
        this.setCode(response.status);
        return;
      }

      this.photo.comments = [response.data, ...this.photo.comments];
    },
    async onSubmit() {
      if (this.comment) {
        await this.addComment();
        this.clearInput();
      }
    },
    clearInput() {
      this.comment = '';
      this.errors = null;
    }
  },
  watch: {
    $rotue: {
      async handler() {
        this.clearInput();
        await this.fetchPhoto();
      },
      immediate: true
    }
  }
};
</script>

<style></style>
