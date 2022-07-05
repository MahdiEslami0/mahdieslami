<template>
  <div class="container">
    <h2 class="mb-3">ویرایش کاربر : {{ user_name }}</h2>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'dashbord' }"><a>داشبورد</a></router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          <router-link :to="{ name: 'users' }"
            ><a>لیست کاربران </a></router-link
          >
        </li>
        <li class="breadcrumb-item active" aria-current="page">ویرایش کاربر</li>
      </ol>
    </nav>
    <div class="row">
      <div class="card shadow-lg mb-5">
        <div class="card-header text-end"></div>
        <div class="card-body">
          <div class="d-flex justify-content-center mb-4" v-if="dataloading">
            <div class="wrapper-parent">
              <div class="text">درحال بارگزاری</div>
              <div class="colors-container">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
              </div>
            </div>
          </div>
          <div class="row" v-else>
            <div class="col-md-6">
              <h3 class="mb-3 opacity-75">اطلاعات کاربری :</h3>
              <div class="text-center">
                <img
                  src="https://www.gravatar.com/avatar/8ea91a667cca5c3ffbc373f73c34821a?s=100"
                  style="border-radius: 50%"
                  class="mb-4"
                />
                <div class="row">
                  <div class="col-md-6">
                    <p>
                      <span class="fs-5 text-primary">تاریخ ثبت نام</span> :
                      {{
                        moment(data.created_at).format("HH:mm:ss jYYYY/jM/jD")
                      }}
                    </p>
                  </div>
                  <div class="col-md-6">
                    <p>
                      <span class="fs-5 text-primary">تاریخ ویرایش</span> :
                      {{
                        moment(data.updated_at).format("HH:mm:ss jYYYY/jM/jD")
                      }}
                    </p>
                  </div>
                  <div class="col-md-12">
                    <div class="wallet-temp shadow-lg">
                      <div class="wallet-info">
                        <h1>کیف پول</h1>
                        <p class="mt-4">
                          موجودی : <span class="fs-4">0 تومان</span>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h3 class="mb-3 opacity-75">مشخصات کاربری :</h3>
              <form @submit.prevent="validation">
                <div class="row">
                  <div class="col-md-6">
                    <label class="text-muted mb-2">نام کاربری :</label>
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
                  <div class="col-md-6 mb-3">
                    <label class="text-muted mb-2">ایمیل :</label>
                    <input
                      class="form-control ui-input"
                      placeholder="ایمیل"
                      v-model="form.email"
                    />
                    <p class="text-danger mt-1" style="text-align: right">
                      {{ form.emailErrorText }}
                    </p>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="text-muted mb-2">سطح دسترسی :</label>
                    <select class="form-control ui-input" v-model="form.role">
                      <option value="1">کاربر</option>
                      <option value="2">ادمین</option>
                      <option value="3" v-if="data.user_role == 3">
                        مالک سایت
                      </option>
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="text-muted mb-2">وضعیت :</label>
                    <select class="form-control ui-input" v-model="form.status">
                      <option value="1">فعال</option>
                      <option value="2">غیرفعال</option>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <label class="text-muted mb-2">بایو :</label>
                    <textarea
                      class="form-control ui-input"
                      placeholder="بایو"
                      cols="30"
                      rows="10"
                      v-model="form.bio"
                    ></textarea>
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn mt-3 update-user-btn"
                  v-if="!formloading"
                >
                  ثبت اطلاعات
                </button>
                <button
                  type="submit"
                  class="btn mt-3 update-user-btn"
                  v-if="formloading"
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
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref, reactive } from "@vue/composition-api";
import Swal from "sweetalert2";
import moment from "moment-jalaali";
export default {
  name: "usersupdate",
  setup(props, { root: { $route } }) {
    const data = ref({});
    const dataloading = ref(true);
    const formloading = ref(false);
    const form = reactive({
      email: "",
      username: "",
      role: "",
      status: "",
      bio: "",
      emailErrorText: "",
      usernameErrorText: "",
    });
    function get_data() {
      axios
        .get(`/api/user-info/${$route.params.id}`, {
          headers: {
            Authorization: `Bearer ${$cookies.get("user_token")}`,
          },
        })
        .then(function (response) {
          dataloading.value = false;
          data.value = response.data.data.user;
          form.username = response.data.data.user.user_name;
          form.email = response.data.data.user.user_email;
          form.bio = response.data.data.user.user_bio;
          form.role = response.data.data.user.user_role;
          form.status = response.data.data.user.user_status;
        })
        .catch(function (error) {
          Swal.fire({
            icon: "error",
            title: "خطا در بازگشت اطلاعات از سرور!",
            html: "تلاش مجدد بعد از <b></b> میلی ثانیه.",
            timer: 10000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading();
              const b = Swal.getHtmlContainer().querySelector("b");
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft();
              }, 100);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log("I was closed by the timer");
            }
          });
          setTimeout(function () {
            getitems();
          }, 10000);
        });
    }
    get_data();
    function validation() {
      if (form.email == "") {
        form.emailErrorText = "ایمیل اجباری است";
      } else {
        form.emailErrorText = "";
      }
      if (form.username == "") {
        form.usernameErrorText = "نام کاربری اجباری است";
      } else {
        form.usernameErrorText = "";
      }
      if (form.email != "" && form.username != "") {
        sendform();
      }
    }
    function sendform() {
      formloading.value = true;
      axios
        .post(
          `/api/user-update/${$route.params.id}`,
          {
            email: form.email,
            username: form.username,
            bio: form.bio,
            role: form.role,
            status: form.status,
          },
          {
            headers: {
              Authorization: `Bearer ${$cookies.get("user_token")}`,
            },
          }
        )
        .then(function (response) {
          Swal.fire({
            icon: "success",
            title: "اطلاعات با موفقیت بروز شد",
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
          get_data();
          formloading.value = false;
        })
        .catch(function (error) {
          Swal.fire({
            icon: "success",
            title: error.response.data.email,
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
          formloading.value = false;
        });
    }
    return {
      user_id: $route.params.id,
      user_name: $route.params.name,
      get_data,
      data,
      dataloading,
      form,
      validation,
      formloading,
      moment,
    };
  },
  metaInfo() {
    return {
      title: `${process.env.MIX_APP_NAME} | ویرایش کاربر : ${this.user_name}`,
    };
  },
};
</script>

<style>
</style>