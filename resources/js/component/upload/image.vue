<template>
  <div class="mymodal" style="display: block" v-if="upload">
    <div class="modal-dialog" style="margin-top: 100px">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">گالری تصاویر</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
            @click="(upload = !upload), passEvent(null)"
          ></button>
        </div>
        <div class="container">
          <label class="form-label">تصویر</label
          ><input
            class="form-control"
            type="file"
            @change="uploadImage"
            name="image"
            id="image"
            accept="image/*"
          />
          <p class="color-danger text-muted mt-2">
            {{ form.imageMessage }}
          </p>
          <div v-if="images.length < 1">
            <h3 class="text-muted mt-5 text-center">تصویری یافت نشد</h3>
          </div>
          <div class="row my-5 p-3">
            <div class="col-md-3 my-2" v-for="image in images" :key="image">
              <div class="shadow-lg">
                <div class="d-flex justify-content-center">
                  <img
                    :src="path + '/' + image"
                    height="150px"
                    width="100%"
                    @click="
                      passEvent('uploads/images' + '/' + image),
                        (upload = !upload)
                    "
                  />
                </div>
                <div class="d-flex justify-content-center mt-3">
                  <i
                    class="bi bi-trash3-fill text-danger"
                    @click="remove('uploads/images' + '/' + image)"
                    style="margin-left: 10px"
                  ></i>
                  <a v-bind:href="path + '/' + image">
                    <i class="bi bi-eye-fill"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref, reactive } from "@vue/composition-api";
export default {
  name: "image",
  setup() {
    const images = ref({});
    const form = reactive({
      imageMessage: "",
    });
    function get_files() {
      axios.get(`/api/image-get`).then(function (response) {
        images.value = response.data.data.image;
      });
    }
    get_files();
    function uploadImage(e) {
      let img = e.target.files[0];
      let fd = new FormData();
      fd.append("image", img);
      axios
        .post(`/api/image-upload`, fd)
        .then(function (response) {
          response;
          form.imageMessage = "تصویر با موفقیت آپلود شد";
          get_files();
        })
        .catch(function (error) {
          form.imageMessage = error.response.data.message.image;
        });
      //   if (loading.value == true) {
      //     form.imageMessage = "درحال آپلود";
      //   }
    }
    function remove(pathurl) {
      axios
        .post(`/api/image-delete`, {
          path: pathurl,
        })
        .then(function (response) {
          get_files();
        });
    }
    function passEvent(url) {
      this.$emit("url", url);
    }

    return {
      images,
      path: "/uploads/images",
      uploadImage,
      form,
      remove,
      passEvent,
    };
  },

  props: {
    upload: {
      default: () => {
        return [];
      },
    },
  },
};
</script>

<style>
</style>