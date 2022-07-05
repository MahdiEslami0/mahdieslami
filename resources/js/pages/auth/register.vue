<template>
  <div class="mt-4">
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
    <div class="login-container bg-white p-5 mb-5">
      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <h2 class="text-primary">ثبت نام 👥</h2>
            <p class="text-muted">با یکی از روش های زیر ثبت نام کنید :</p>
            <social />
            <p class="fs-7 text-muted">یا ثبت نام به حساب با</p>
            <form class="mt-3" @submit.prevent="validation">
              <div class="input-dev">
                <i class="bi bi-person-circle input-icon"></i>
                <input
                  class="form-control auth-input"
                  type="text"
                  placeholder="نام کاربری"
                  v-model="form.username"
                  v-if="!form.usernameErrorText"
                />
                <input
                  class="form-control auth-input is-invalid"
                  type="text"
                  placeholder="نام کاربری"
                  v-model="form.username"
                  v-else
                />
                <p class="text-danger mt-1" style="text-align: right">
                  {{ form.usernameErrorText }}
                </p>
              </div>
              <br />
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
                v-if="!registerloading"
              >
                ثبت نام
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
              حساب کاربری دارید ؟
              <router-link to="login"
                ><span class="text-primary">وارد شوید</span></router-link
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
export default {
  name: "reigster",
  setup() {
    const form = reactive({
      email: "",
      password: "",
      username: "",
      usernameErrorText: "",
      emailErrorText: "",
      passwordErrorText: "",
    });
    const registerloading = ref(false);
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
      if (form.password === "") {
        form.passwordErrorText = "پسورد اجباری است";
      } else {
        if (
          !/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/.test(
            form.password
          )
        ) {
          form.passwordErrorText =
            "پسورد باید از 8 کارکتر بزرگ و کوچک انگلیسی تشکیل شده باشد";
        } else {
          form.passwordErrorText = "";
        }
      }
      if (
        form.email !== "" &&
        form.password !== "" &&
        form.username !== "" &&
        /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form.email) &&
        /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/.test(
          form.password
        )
      ) {
        register();
      }
    }
    function register() {
      registerloading.value = true;
      axios
        .post("/api/register", {
          username: form.username,
          email: form.email,
          password: form.password,
        })
        .then(function (response) {
          store.dispatch("user/login");
          response;
          registerloading.value = false;
          $cookies.set("user_token", response.data.data.token, "7d");
          Swal.fire({
            icon: "success",
            title: "ثبت نام با موفقیت انجام شد",
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
          router.push("/");
        })
        .catch(function (error) {
          registerloading.value = false;
          if (error.response.data.message.email) {
            Swal.fire({
              icon: "error",
              title: error.response.data.message.email,
              toast: true,
              position: "top",
              showConfirmButton: false,
              timer: 4000,
              timerProgressBar: true,
            });
          }
          if (error.response.data.message.username) {
            Swal.fire({
              icon: "error",
              title: error.response.data.message.username,
              toast: true,
              position: "top",
              showConfirmButton: false,
              timer: 4000,
              timerProgressBar: true,
            });
          }
        });
    }
    return {
      sitename: process.env.MIX_APP_NAME,
      logo: "../assets/VueLur.png",
      registerloading,
      form,
      validation,
    };
  },
  metaInfo: {
    titleTemplate: `${process.env.MIX_APP_NAME} | ثبت نام`,
  },
  components: { social },
};
</script>

<style>
</style>