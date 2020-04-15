<template>
  <transition name="modal">
    <div v-show="showForm" class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <h2 class="mb-4">Submit a photo</h2>
          <!-- error message -->
          <div v-if="errors" class="alert alert-danger">
            <div v-if="errors.photo">
              <p class="p-0 m-0" v-for="message in errors.photo" :key="message">
                {{ message }}
              </p>
            </div>
          </div>
          <!-- form -->
          <form @submit.prevent="onSubmit">
            <div class="form-group">
              <input
                type="file"
                class="form-control-file"
                @change="onFileChange"
              />
            </div>
            <output v-if="preview" class="d-block mb-2">
              <img class="w-100" :src="preview" alt="image preview" />
            </output>
            <button
              class="btn btn-outline-secondary"
              @click.prevent="$emit('close')"
            >
              Cancel
            </button>
            <button type="submit" class="btn btn-success">
              Submit
            </button>
          </form>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import { mapActions } from 'vuex';
import { CREATED, UNPROCESSABLE_ENTITY } from '../util';

export default {
  data() {
    return {
      preview: '',
      photo: null,
      errors: null
    };
  },
  props: ['showForm'],
  methods: {
    ...mapActions('error', ['setCode']),
    reset() {
      this.preview = '';
      this.photo = null;
      this.$el.querySelector('input[type="file"]').value = '';
    },
    onFileChange(event) {
      if (event.target.files.length === 0) {
        this.reset();
        return;
      }
      if (!event.target.files[0].type.match('image.*')) {
        this.reset();
        return;
      }

      const reader = new FileReader();
      reader.onload = e => {
        this.preview = e.target.result;
      };
      reader.readAsDataURL(event.target.files[0]);

      this.photo = event.target.files[0];
    },
    async onSubmit() {
      const formData = new FormData();
      formData.append('photo', this.photo);

      const response = await axios.post('/api/photos', formData);

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.errors = response.data.errors;
        return;
      }

      this.reset();
      this.$emit('close');

      // transition to error page
      if (response.status != CREATED) {
        this.setCode(response.status);
        return;
      }

      // redirect to photo detail page
    }
  },
  watch: {
    showForm(value) {
      if (value) {
        this.errors = null;
      }
    }
  }
};
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 1000;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 80%;
  max-width: 600px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
}

/** MODAL ANIMATION */
.modal-enter {
  opacity: 0;
  transform: scale(1.1);
}

.modal-leave-to {
  opacity: 0;
  transform: scale(1.1);
}

.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease;
}
</style>
