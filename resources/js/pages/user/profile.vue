<template>
  <div>
    <div class="profile-main space-in-mobile">
      <div class="spinner-border" role="status" v-if="user_data_loading"></div>
      <form @submit.prevent="validation" v-if="!user_data_loading">
        <h3 class="mb-4">اطلاعات حساب :</h3>
        <div class="row">
          <div class="col-md-6">
            <label class="mb-2 text-muted">نام کاربری :</label>
            <input
              type="text"
              class="form-control ui-input"
              placeholder="نام کاربری"
              v-model="form.username"
            />
            <p class="text-danger mt-1" style="text-align: right">
              {{ form.usernameErrorText }}
            </p>
          </div>
          <div class="col-md-6">
            <label class="mb-2 text-muted">ایمیل :</label>
            <input
              type="text"
              class="form-control ui-input"
              placeholder="ایمیل"
              v-model="form.email"
              v-if="!form.passwordErrorText"
            />
            <p class="text-danger mt-1" style="text-align: right">
              {{ form.emailErrorText }}
            </p>
          </div>
          <div class="col-md-12 mt-3">
            <label class="mb-2 text-muted">Bio :</label>
            <textarea
              class="form-control ui-input mb-4"
              rows="10"
              placeholder="توضیح مختصر درباره خود و حرفه فعالیتتون 🗂"
              v-model="form.bio"
            ></textarea>
          </div>
          <div class="row" v-if="password">
            <div class="col-md-6 mb-4">
              <label class="mb-2 text-muted">پسوردفعلی :</label>
              <input
                type="password"
                class="form-control ui-input"
                placeholder="پسوردفعلی"
                v-model="form.last_password"
              />
            </div>
            <div class="col-md-6 mb-4">
              <label class="mb-2 text-muted">پسوردجدید :</label>
              <input
                type="password"
                class="form-control ui-input"
                placeholder="پسوردجدید"
                v-model="form.new_password"
              />
            </div>
          </div>
          <div>
            <label
              class="mb-2 text-muted"
              style="
                display: block;
                position: relative;
                padding-left: 35px;
                margin-bottom: 12px;
                cursor: pointer;
                font-size: 15px;
              "
              >تغییر رمز عبور
              <input
                type="checkbox"
                class="checkbox"
                @change="password = !password"
              />
            </label>
          </div>
        </div>

        <button
          type="submit"
          class="btn btn-primary mt-3 ui-sub-btn"
          style="border-radius: 0.5rem;with"
          v-if="!user_form_loading"
        >
          ثبت اطلاعات
        </button>
        <button
          type="submit"
          class="btn btn-primary mt-3 ui-sub-btn"
          style="border-radius: 0.5rem;with"
          v-if="user_form_loading"
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
      <h3 class="mt-5">اتصال به اکانت ها :</h3>
      <div class="col-md-12 mt-3">
        <div class="row my-4">
          <div class="col-md-6">
            <button
              class="btn login-item"
              style="background-color: #229ed9; color: #fff"
              disabled
            >
              اتصال با تلگرام
            </button>
          </div>
          <div class="col-md-6">
            <a href="./auth/google">
              <button
                class="btn login-item"
                style="background-color: #db4437; color: #fff"
              >
                اتصال با گوگل
              </button>
            </a>
          </div>
          <div class="col-md-6">
            <a href="./auth/github">
              <button
                class="btn login-item"
                style="background-color: black; color: #fff"
              >
                اتصال با گیت هاب
              </button>
            </a>
          </div>
          <div class="col-md-6">
            <button
              class="btn login-item"
              style="background-color: #0a66c2; color: #fff"
              disabled
            >
              اتصال با لینکدین
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from "@vue/composition-api";
import axios from "axios";
import Swal from "sweetalert2";
export default {
  name: "profile",
  setup() {
    const password = ref(false);
    const user_data_loading = ref(true);
    const user_form_loading = ref(false);
    const form = reactive({
      email: "",
      username: "",
      last_password: "",
      new_password: "",
      bio: "",
      emailErrorText: "",
      usernameErrorText: "",
    });
    function validation() {
      if (form.username === "") {
        form.usernameErrorText = "نام کاربری اجباری است";
      } else {
        form.usernameErrorText = "";
      }
      if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form.email)) {
        form.emailErrorText = "یک ایمیل درست وارد کنید !";
      } else {
        form.emailErrorText = "";
      }
      if (
        form.username !== "" &&
        /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form.email)
      ) {
        user_update();
      }
    }
    function get_user_data() {
      user_data_loading.value = true;
      axios
        .get("api/user-info", {
          headers: {
            Authorization: `Bearer ${$cookies.get("user_token")}`,
          },
        })
        .then(function (response) {
          form.username = response.data.data.user.user_name;
          form.email = response.data.data.user.user_email;
          form.bio = response.data.data.user.user_bio;
          form.new_password = "";
          form.last_password = "";

          user_data_loading.value = false;
        });
    }
    get_user_data();
    function user_update() {
      user_form_loading.value = true;
      axios
        .post(
          "api/user-update",
          {
            username: form.username,
            email: form.email,
            bio: form.bio,
            last_password: form.last_password,
            new_password: form.new_password,
          },
          {
            headers: {
              Authorization: `Bearer ${$cookies.get("user_token")}`,
            },
          }
        )
        .then(function (response) {
          response;
          user_form_loading.value = false;
          Swal.fire({
            icon: "success",
            title: "اطلاعات کاربری با موفقیت بروز شد",
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
          get_user_data();
        })
        .catch(function (error) {
          user_form_loading.value = false;
          Swal.fire({
            icon: "error",
            title: error.response.data.message,
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
        });
    }
    return { password, form, validation, user_data_loading, user_form_loading };
  },
  metaInfo: {
    titleTemplate: `${process.env.MIX_APP_NAME} | اطلاعات کاربری`,
  },
};
</script>

<style>
</style>