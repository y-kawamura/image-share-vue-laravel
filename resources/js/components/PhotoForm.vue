<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <h2 class="mb-4">Submit a photo</h2>
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
            <button class="btn btn-outline-secondary" @click="$emit('close')">
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
export default {
  data() {
    return {
      preview: '',
      photo: null
    };
  },
  methods: {
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

      this.reset();
      this.$emit('close');
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
  transition: opacity 0.3s ease;
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
  transition: all 0.3s ease;
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  transform: scale(1.1);
}
</style>
