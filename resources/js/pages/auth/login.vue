<template>
  <div class="mt-5">
    <div class="text-center">
      <router-link to="/">
        <img
          v-bind:src="logo"
          height="60"
          class="d-inline-block align-text-top"
        />
        <p class="fs-4 text-black">{{ sitename }}</p>
      </router-link>
    </div>
    <div class="login-container bg-white p-5">
      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <h2 class="text-primary">خوش آمدید ❤️</h2>
            <p class="text-muted">با یکی از روش های زیر وارد شوید :</p>
            <social />
            <p class="fs-7 text-muted">یا ورود به حساب با</p>
            <form class="mt-3" @submit.prevent="validation">
              <div class="input-dev">
                <i class="bi bi-envelope input-icon"></i>
                <input
                  class="form-control auth-input"
                  type="text"
                  placeholder="ایمیل"
                  v-model="form.email"
                  v-if="!form.emailErrorText"
                />
                <input
                  class="form-control auth-input is-invalid"
                  type="text"
                  placeholder="ایمیل"
                  v-model="form.email"
                  v-else
                />
                <p class="text-danger mt-1" style="text-align: right">
                  {{ form.emailErrorText }}
                </p>
              </div>

              <br />
              <div class="input-dev">
                <i class="bi bi-key input-icon"></i>
                <input
                  class="form-control auth-input"
                  type="password"
                  placeholder="رمز عبور"
                  v-model="form.password"
                  v-if="!form.passwordErrorText"
                />
                <input
                  class="form-control auth-input is-invalid"
                  type="password"
                  placeholder="رمز عبور"
                  v-else
                  v-model="form.password"
                />
                <p class="text-danger mt-1" style="text-align: right">
                  {{ form.passwordErrorText }}
                </p>
              </div>
              <br />
              <button
                class="btn btn-primary input-dev login-auth-btn"
                v-if="!loginloading"
              >
                ورود
              </button>
              <button
                class="btn btn-primary input-dev login-auth-btn"
                v-else
                disabled
              >
                <span
                  class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"
                ></span>
                <span class="sr-only">درحال بررسی</span>
              </button>
            </form>
            <p class="text-muted mt-3">
              حساب کاربری ندارید ؟
              <router-link to="register"
                ><span class="text-primary">ثبت نام کنید</span></router-link
              >
            </p>
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
import router from "../../router/router";
import store from "../../store/store";
import social from "./social.vue";
import { useRoute } from "vue-router";
export default {
  name: "login",
  setup() {
    let urlParams = new URLSearchParams(window.location.search);
    let myurlParams = urlParams.get("status");
    if (myurlParams == "ban") {
      Swal.fire({
        icon: "error",
        title: "حساب کاربری شما مسدود است",
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
      });
    }
    const form = reactive({
      email: "",
      password: "",
      emailErrorText: "",
      passwordErrorText: "",
    });
    const loginloading = ref(false);
    function validation() {
      if (form.email === "") {
        form.emailErrorText = "ایمیل اجباری است";
      } else {
        form.emailErrorText = "";
      }
      if (form.password === "") {
        form.passwordErrorText = "پسورد اجباری است";
      } else {
        form.passwordErrorText = "";
      }
      if (form.email !== "" && form.password !== "") {
        login();
      }
    }
    function login() {
      loginloading.value = true;
      axios
        .post("/api/login", {
          email: form.email,
          password: form.password,
        })
        .then(function (response) {
          store.dispatch("user/login");
          response;
          loginloading.value = false;
          $cookies.set("user_token", response.data.data.token, "7d");
          Swal.fire({
            icon: "success",
            title: "با موفقیت وارد شدید",
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
          router.push("/");
        })
        .catch(function (error) {
          loginloading.value = false;
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
    return {
      form,
      validation,
      loginloading,
      sitename: process.env.MIX_APP_NAME,
      logo: "../assets/VueLur.png",
    };
  },
  metaInfo: {
    titleTemplate: `${process.env.MIX_APP_NAME} | ورود`,
  },
  components: {
    social,
  },
};
</script>

<style>
</style>