<template>
  <div class="container">
    <h2 class="mb-3">مدیریت کاربران</h2>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'dashbord' }"><a>داشبورد</a></router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">لیست کاربران</li>
      </ol>
    </nav>
    <div class="row">
      <div class="card shadow-lg">
        <div class="card-header text-end">
          <!-- <button class="btn btn-light-primary">
            <i class="bi bi-funnel-fill"></i>
            افزودن
          </button> -->
        </div>
        <div class="card-body">
          <form class="mb-5" @submit.prevent="getitems">
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
                  v-model="form.search"
                />
              </div>
              <div class="col-md-2">
                <label class="text-muetd mb-2">وضعیت :</label>
                <select class="form-control" v-model="form.status">
                  <option value="">انتخاب کنید</option>
                  <option value="1">فعال</option>
                  <option value="2">غیرفعال</option>
                </select>
              </div>
              <div class="col-md-2">
                <label class="text-muetd mb-2">سطح دسترسی :</label>
                <select class="form-control" v-model="form.role">
                  <option value="">انتخاب کنید</option>
                  <option value="1">کاربر</option>
                  <option value="2">ادمین</option>
                  <option value="3">مالک</option>
                </select>
              </div>
              <div class="col-md-2">
                <button
                  class="btn btn-primary"
                  style="margin-top: 30px"
                  v-if="!filter_loading"
                >
                  <i class="bi bi-funnel-fill"></i>
                  اعمال
                </button>
                <button
                  class="btn btn-primary"
                  disabled
                  style="margin-top: 30px"
                  v-else
                >
                  <i class="bi bi-funnel-fill"></i>
                  درحال بارگزاری ...
                  <span
                    class="spinner-grow spinner-grow-sm"
                    role="status"
                    aria-hidden="true"
                  ></span>
                </button>
              </div>
            </div>
          </form>
          <div class="d-flex justify-content-center mb-4" v-if="list_loading">
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
          <div class="table-responsive" v-else>
            <div class="text-muted fs-3 text-center" v-if="items.length < 1">
              <p>نتیجه ای یافت نشد!</p>
            </div>
            <table
              class="
                table table-hover
                align-middle
                table table-striped
                border-dark
              "
              v-else
            >
              <thead class="table-dark">
                <tr>
                  <th>#</th>
                  <th>یوزرنیم</th>
                  <th>ایمیل</th>
                  <th>وضعیت</th>
                  <th>سطح دسترسی</th>
                  <th @click="orderby">تاریخ ثبت نام</th>
                  <th>عملیات</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="item in items"
                  :key="item.user_id"
                  v-bind:class="{ 'table-primary': item.user_role == 3 }"
                >
                  <td>{{ item.user_id }}</td>
                  <td class="text-muted">{{ item.user_name }}</td>
                  <td class="text-muted">{{ item.user_email }}</td>
                  <td class="text-muted">
                    <div class="form-check form-switch">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="flexSwitchCheckDefault"
                        v-if="item.user_status == 1"
                        checked
                        @change="update_item_status(item.user_id, 2)"
                      />
                      <input
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="flexSwitchCheckDefault"
                        v-if="item.user_status == 2"
                        @change="update_item_status(item.user_id, 1)"
                      />
                    </div>
                  </td>
                  <td class="text-muted">
                    <span class="info-label" v-if="item.user_role == 1"
                      >کاربر ساده</span
                    >
                    <span class="gold-label" v-if="item.user_role == 2">
                      <img
                        src="/images/verify-tik.png"
                        height="15px"
                        alt="ادمین"
                      />
                      ادمین
                    </span>
                    <span class="gold-label" v-if="item.user_role == 3">
                      <img
                        src="/images/verify-tik.png"
                        height="15px"
                        alt="ادمین"
                      />
                      مالک سایت
                    </span>
                  </td>
                  <td class="text-muted">
                    {{ moment(item.created_at).format("HH:mm:ss jYYYY/jM/jD") }}
                  </td>
                  <td>
                    <div class="dropdown">
                      <button
                        class="btn btn-light-primary dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton1"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        عملیات
                      </button>
                      <ul
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuButton1"
                      >
                        <router-link
                          :to="{
                            name: 'usersupdate',
                            params: { id: item.user_id, name: item.user_name },
                          }"
                        >
                          <li><a class="dropdown-item">ویرایش</a></li>
                        </router-link>
                        <li>
                          <a
                            class="dropdown-item"
                            @click="delete_item(item.user_id)"
                            style="cursor: pointer"
                            >حذف</a
                          >
                        </li>
                      </ul>
                    </div>
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
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from "@vue/composition-api";
import axios from "axios";
import Swal from "sweetalert2";
import moment from "moment-jalaali";
export default {
  name: "users",
  setup() {
    const items = ref({});
    const list_loading = ref(true);
    const filter_loading = ref(false);
    const page_num = ref(1);
    const page_total = ref(0);
    let A2 = "desc";
    const form = reactive({
      search: "",
      role: "",
      status: "",
      order: "asc",
    });
    function orderby() {
      if (A2 == "asc") {
        A2 = "desc";
      } else {
        A2 = "asc";
      }
      console.log(A2);
      getitems();
    }
    function load_items(n) {
      page_num.value = n;
      getitems();
    }
    function getitems() {
      filter_loading.value = true;
      axios
        .post(
          `/api/get-users?page=${page_num.value}`,
          {
            role: form.role,
            status: form.status,
            search: form.search,
            order: A2,
          },
          {
            headers: {
              Authorization: `Bearer ${$cookies.get("user_token")}`,
            },
          }
        )
        .then(function (response) {
          items.value = response.data.data.users.data;
          list_loading.value = false;
          filter_loading.value = false;

          page_total.value = response.data.data.users.last_page;
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
    function update_item_status(id, status) {
      axios
        .get(`/api/update_user_status/${id}/${status}`, {
          headers: {
            Authorization: `Bearer ${$cookies.get("user_token")}`,
          },
        })
        .then(function (responsive) {
          responsive;
          Swal.fire({
            icon: "success",
            title: "وضعیت کاربر بروز شد",
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
        })
        .catch(function (erro) {
          Swal.fire({
            icon: "error",
            title: "خطا در انجام عملیات",
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
        });
    }
    function delete_item(id) {
      axios
        .get(`/api/delete_user/${id}`, {
          headers: {
            Authorization: `Bearer ${$cookies.get("user_token")}`,
          },
        })
        .then(function (response) {
          response;
          Swal.fire({
            icon: "success",
            title: "کاربر با موفقیت حذف شد",
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
          getitems();
        })
        .catch(function (error) {
          error;
          Swal.fire({
            icon: "error",
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
      items,
      update_item_status,
      list_loading,
      delete_item,
      page_num,
      load_items,
      page_total,
      form,
      getitems,
      orderby,
      A2,
      moment,
      filter_loading,
      upload: false,
    };
  },
  metaInfo: {
    titleTemplate: `${process.env.MIX_APP_NAME} | مدیریت کاربران`,
  },
};
</script>

<style>
</style>