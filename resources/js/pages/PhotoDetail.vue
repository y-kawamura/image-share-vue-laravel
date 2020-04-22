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
          <like-button
            :likesCount="photo.likes_count"
            :likedByUser="photo.liked_by_user"
            @clickLike="onClickLike"
          />
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
import { mapState, mapActions, mapGetters } from 'vuex';
import LikeButton from '../components/LikeButton.vue';
import DownloadButton from '../components/DownloadButton.vue';
import CommentCard from '../components/CommentCard.vue';

export default {
  data() {
    return {
      comment: ''
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
    ...mapState('photo', ['photo']),
    ...mapGetters('auth', ['isLoggedIn'])
  },
  methods: {
    ...mapActions('error', ['setCode']),
    ...mapActions('photo', ['fetchPhoto', 'addComment', 'like', 'unlike']),
    async onSubmit() {
      if (this.comment) {
        await this.addComment({ id: this.id, content: this.comment });
        this.clearInput();
      }
    },
    clearInput() {
      this.comment = '';
    },
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
  },
  watch: {
    $rotue: {
      async handler() {
        this.clearInput();
        await this.fetchPhoto(this.id);
      },
      immediate: true
    }
  }
};
</script>

<style></style>
