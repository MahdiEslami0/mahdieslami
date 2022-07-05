<template>
  <div class="container">
    <h2 class="mb-3">افزودن دسته بندی</h2>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'dashbord' }"><a>داشبورد</a></router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'category' }"
            ><a>دسته بندی ها</a></router-link
          >
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          افزودن دسته بندی
        </li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow-lg mb-5 px-5">
          <div class="card-header mt-3"></div>
          <div class="card-body">
            <form class="mb-5" @submit.prevent="validate">
              <div class="row">
                <div class="col-md-6 mb-4">
                  <label class="text-muted mb-2">نام دسته :</label>
                  <input
                    type="text"
                    class="form-control ui-input"
                    placeholder="نام دسته"
                    v-model="form.name"
                  />
                  <p class="text-danger mt-1" style="text-align: right">
                    {{ form.nameerorr }}
                  </p>
                </div>
                <div class="col-md-6 mb-4">
                  <label class="text-muted mb-2">slug:</label>
                  <input
                    type="text"
                    class="form-control ui-input"
                    placeholder="نام مستعار , مانند : learn-english-in-20-day"
                    v-model="form.slug"
                  />
                  <p class="text-danger mt-1" style="text-align: right">
                    {{ form.slugerorr }}
                  </p>
                </div>
                <div class="col-md-6 mb-4">
                  <label class="text-muted mb-2"
                    >تصویر | لوگو دسته بندی :</label
                  >
                  <div class="input-group mb-3">
                    <div
                      class="input-group-prepend"
                      @click="(upload = !upload), (form.image = null)"
                    >
                      <span
                        class="input-group-text"
                        id="inputGroup-sizing-default"
                        >انتخاب</span
                      >
                    </div>
                    <input
                      type="text"
                      class="form-control"
                      aria-label="Default"
                      aria-describedby="inputGroup-sizing-default"
                      v-model="form.image"
                      disabled
                    />
                  </div>
                  <img
                    :src="'/' + form.image"
                    height="100px"
                    v-if="form.image !== null"
                  />
                </div>
                <div class="col-md-6 mb-4">
                  <label class="text-muted mb-2">دسته والد:</label>
                  <select class="form-control ui-input" v-model="form.parent">
                    <option value="">اصلی</option>
                    <option
                      v-for="item in items"
                      :key="item"
                      v-bind:value="item.c_id"
                    >
                      {{ item.c_name }}
                    </option>
                  </select>
                </div>
                <div class="col-md-6 mb-4">
                  <label class="text-muted mb-2">وضعیت:</label>
                  <select class="form-control ui-input" v-model="form.status">
                    <option value="1">فعال</option>
                    <option value="2">غیرفعال</option>
                  </select>
                </div>
                <div class="col-md-12 mb-4">
                  <label class="text-muted mb-2">توضیحات:</label>
                  <textarea
                    class="form-control ui-input"
                    cols="30"
                    rows="10"
                    placeholder="توضیحات در باره دسته برای بهینه سازی کلمات کلیدی و تقویت SEO"
                    v-model="form.decription"
                  ></textarea>
                </div>
              </div>
              <button
                type="submit"
                class="btn mt-3 update-user-btn"
                v-if="form_loading == false"
              >
                ثبت اطلاعات
              </button>
              <button
                type="submit"
                class="btn mt-3 update-user-btn"
                v-if="form_loading == true"
                disabled
              >
                درحال بررسی
                <span
                  class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"
                ></span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <upload
      :upload="upload"
      @url="passEvent($event)"
      @close="closeEvent($event)"
    />
  </div>
</template>

<script>
import { ref, reactive } from "@vue/composition-api";
import upload from "../../../component/upload/image.vue";
import axios from "axios";
import Swal from "sweetalert2";
export default {
  setup() {
    const upload = ref(false);
    const form_loading = ref(false);
    const items = ref({});
    const form = reactive({
      name: "",
      slug: "",
      status: "1",
      decription: "",
      parent: "",
      nameerorr: "",
      slugerorr: "",
      image: null,
    });
    function get_items() {
      axios
        .get(`/api/get-category`, {
          headers: {
            Authorization: `Bearer ${$cookies.get("user_token")}`,
          },
        })
        .then(function (response) {
          items.value = response.data.data.parents;
        });
    }
    get_items();
    function passEvent(url) {
      form.image = url;
      upload.value = false;
    }
    function validate() {
      if (form.name == "") {
        form.nameerorr = "نام دسته اجباری است";
      } else {
        form.nameerorr = "";
      }
      if (form.slug == "") {
        form.slugerorr = "slug دسته اجباری است";
      } else {
        form.slugerorr = "";
      }
      if (form.slug != "" && form.slug != "") {
        sendform();
      }
    }
    function sendform() {
      form_loading.value = true;
      axios
        .post(
          `/api/create-category`,
          {
            name: form.name,
            slug: form.slug,
            decription: form.decription,
            status: form.status,
            parent: form.parent,
            image: form.image,
          },
          {
            headers: {
              Authorization: `Bearer ${$cookies.get("user_token")}`,
            },
          }
        )
        .then(function (response) {
          get_items();
          form_loading.value = false;
          Swal.fire({
            icon: "success",
            title: "دسته با موفقیت ثبت شد",
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
          form.name = "";
          form.slug = "";
          form.image = null;
          form.status = "1";
          form.parent = "";
          form.decription = "";
        });
    }
    return {
      upload,
      passEvent,
      form,
      validate,
      form_loading,
      items,
      get_items,
    };
  },
  components: {
    upload,
  },
};
</script>

<style>
</style>