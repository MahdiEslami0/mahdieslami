<template>
  <div class="container">
    <h2 class="mb-3">دسته بندی ها</h2>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'dashbord' }"><a>داشبورد</a></router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">دسته بندی ها</li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow-lg mb-5">
          <div class="card-header text-end">
            <router-link :to="{ name: 'category-create' }">
              <button class="btn btn-light-primary">
                <i class="bi bi-plus-circle-dotted"></i>
                افزودن
              </button>
            </router-link>
          </div>
          <div class="card-body">
            <div class="container">
              <form class="mb-5">
                <div
                  class="row"
                  style="
                    background-color: #f5f5f5;
                    padding: 19px;
                    border: 1px solid #e33e3;
                    border-radius: 3px;
                    box-shadow: inset 0 1px 1px rgb(0 0 0 / 5%);
                  "
                >
                  <div class="col-md-4">
                    <label class="text-muetd mb-2">جستوجو :</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="نام کاربری | ایمیل"
                    />
                  </div>
                  <div class="col-md-2">
                    <label class="text-muetd mb-2">وضعیت :</label>
                    <select class="form-control">
                      <option value="">انتخاب کنید</option>
                      <option value="1">فعال</option>
                      <option value="2">غیرفعال</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label class="text-muetd mb-2">سطح دسترسی :</label>
                    <select class="form-control">
                      <option value="">انتخاب کنید</option>
                      <option value="1">کاربر</option>
                      <option value="2">ادمین</option>
                      <option value="3">مالک</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <button class="btn btn-primary" style="margin-top: 30px">
                      <i class="bi bi-funnel-fill"></i>
                      اعمال
                    </button>
                  </div>
                </div>
              </form>
              <div
                class="d-flex justify-content-center mb-4"
                v-if="list_loading"
              >
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
              <div v-if="!list_loading">
                <table class="table table-hover align-middle border-dark">
                  <thead class="table-dark">
                    <tr>
                      <th>نام</th>
                      <th>slug</th>
                      <th>نوع</th>
                      <th>وضعیت</th>
                      <th>عملیات</th>
                    </tr>
                  </thead>
                  <tbody v-for="item in items" :key="item.c_id">
                    <tr>
                      <td>{{ item.c_name }}</td>
                      <td>{{ item.c_slug }}</td>
                      <td>
                        <span v-if="item.c_parent == null">اصلی</span>
                        <span v-else>{{ item.c_parent }}</span>
                      </td>
                      <td>
                        <div class="form-check form-switch">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            role="switch"
                            id="flexSwitchCheckDefault"
                            v-if="item.c_status == 1"
                            @click="change_status(item.c_id, 2)"
                            checked
                          />
                          <input
                            class="form-check-input"
                            type="checkbox"
                            role="switch"
                            id="flexSwitchCheckDefault"
                            v-if="item.c_status == 2"
                            @click="change_status(item.c_id, 1)"
                          />
                        </div>
                      </td>
                      <td>
                        <i
                          class="bi bi-trash3-fill text-danger"
                          style="margin-left: 10px"
                        ></i>
                        <a>
                          <i class="bi bi-eye-fill text-primary"></i>
                        </a>
                      </td>
                    </tr>
                    <tr
                      v-for="item in item.children"
                      :key="item.c_id"
                      class="table-primary"
                    >
                      <td>__ {{ item.c_name }}</td>
                      <td>{{ item.c_slug }}</td>
                      <td>
                        <span v-if="item.c_parent == null">اصلی</span>
                        <span v-else>فرعی</span>
                      </td>
                      <td>
                        <div class="form-check form-switch">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            role="switch"
                            id="flexSwitchCheckDefault"
                            v-if="item.c_status == 1"
                            checked
                          />
                          <input
                            class="form-check-input"
                            type="checkbox"
                            role="switch"
                            id="flexSwitchCheckDefault"
                            v-if="item.c_status == 2"
                          />
                        </div>
                      </td>
                      <td>
                        <i
                          class="bi bi-trash3-fill text-danger"
                          style="margin-left: 10px"
                        ></i>
                        <a>
                          <i class="bi bi-eye-fill text-primary"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <nav
                  class="mt-4"
                  aria-label="Page navigation example"
                  v-if="page_total !== 1"
                >
                  <ul class="pagination justify-content-center">
                    <li class="page-item">
                      <a
                        class="page-link"
                        @click="load_items(--page_num)"
                        aria-label="Previous"
                        v-if="page_num !== 1"
                      >
                        <span aria-hidden="true">«</span>
                      </a>
                    </li>
                    <li
                      v-for="n in page_total"
                      :key="n"
                      class="page-item"
                      v-bind:class="{ active: n === page_num }"
                    >
                      <a class="page-link" @click="load_items(n)">{{ n }}</a>
                    </li>
                    <li class="page-item">
                      <a
                        class="page-link"
                        @click="load_items(++page_num)"
                        aria-label="Next"
                        v-if="page_total !== page_num"
                      >
                        <span aria-hidden="true">»</span>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>
              <div class="text-muted fs-3 text-center" v-if="items.length < 1">
                <p>نتیجه ای یافت نشد!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "@vue/composition-api";
import axios from "axios";
import Swal from "sweetalert2";
export default {
  name: "category",
  setup() {
    const list_loading = ref(true);
    const items = ref({});
    const page_num = ref(1);
    const page_total = ref(0);
    function getitems() {
      axios
        .get(`/api/get-category?page=${page_num.value}`, {
          headers: {
            Authorization: `Bearer ${$cookies.get("user_token")}`,
          },
        })
        .then(function (response) {
          list_loading.value = false;
          items.value = response.data.data.categories.data;
          page_total.value = response.data.data.categories.last_page;
        })
        .catch(function (error) {
          filter_loading.value = false;
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
    getitems();
    function load_items(n) {
      page_num.value = n;
      getitems();
    }
    function change_status(id, status) {
      axios
        .get(`/api/update_category_status/${id}/${status}`, {
          headers: {
            Authorization: `Bearer ${$cookies.get("user_token")}`,
          },
        })
        .then(function (response) {
          getitems();
          Swal.fire({
            icon: "success",
            title: "وضعیت بروز شد !",
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
        })
        .catch(function (error) {
          getitems();
          Swal.fire({
            icon: "erorr",
            title: "خطا در انجام عملیات",
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
        });
    }
    return {
      list_loading,
      items,
      page_num,
      page_total,
      load_items,
      change_status,
    };
  },
};
</script>

<style>
</style>