<template>
  <div>
    <div class="sidebar d-md-none d-sm-block" :class="{ opensidebar: sidebar }">
      <a class="closebtn" style="float: left" @click="sidebar = !sidebar"
        >&times;</a
      >
      <input
        type="text"
        class="form-search-m"
        placeholder="دنبال چی میگردی ؟"
      />
      <a href="#" class="a">صفحه اصلی</a>
      <a href="#" class="a">دسته بندی</a>
      <a href="#" class="a">دباره</a>
      <a href="#" class="a">وبلاگ</a>
      <div class="d-flex justify-content-center" v-if="!loginstatus">
        <router-link to="login">
          <button class="btn login-btn mt-4">
            ورود <i class="bi bi-person-plus"></i>
          </button>
        </router-link>
        <router-link to="register">
          <button class="btn reg-btn mt-4">
            عضویت <i class="bi bi-person-check"></i>
          </button>
        </router-link>
      </div>
      <div class="d-flex justify-content-center mt-5" v-if="loginstatus">
        <div class="" style="display: flex">
          <i class="bi bi-bookmark-fill item-header-icon me-2"></i>
          <i class="bi bi-cart-fill item-header-icon me-2"></i>
          <div class="dropdown" style="display: flex">
            <div
              data-bs-toggle="dropdown"
              aria-expanded="false"
              class="profile d-flex align-items-center"
            >
              <i class="bi bi-person-circle item-header-icon me-2"></i>
            </div>
            <ul
              aria-labelledby="dropdownMenuButton1"
              class="dropdown-menu"
              style=""
            >
              <li>
                <a
                  class="dropdown-item"
                  style="cursor: alias"
                  @click="userlogout()"
                  ><i class="bi bi-box-arrow-left"></i> خروج
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <nav class="navbar navbar-expand-lg navbar-light bg-light site-header">
        <div class="container">
          <router-link to="/">
            <img
              v-bind:src="logo"
              height="60"
              class="d-inline-block align-text-top"
            />
          </router-link>
          <div class="collapse navbar-collapse" id="navbarNav">
            <input
              type="text"
              class="form-search"
              placeholder="دنبال چی میگردی ؟"
            />
          </div>
          <div class="d-flex">
            <span
              class="navbar-toggler-icon d-md-none d-sm-block"
              @click="sidebar = !sidebar"
            ></span>
            <router-link to="login" v-if="!loginstatus">
              <button class="btn login-btn d-none d-md-block">
                ورود <i class="bi bi-person-plus"></i>
              </button>
            </router-link>
            <router-link to="register" v-if="!loginstatus">
              <button class="btn reg-btn d-none d-md-block">
                عضویت <i class="bi bi-person-check"></i>
              </button>
            </router-link>
            <div class="d-none d-sm-block" v-if="loginstatus">
              <div class="" style="display: flex">
                <i class="bi bi-bookmark-fill item-header-icon me-2"></i>
                <i class="bi bi-cart-fill item-header-icon me-2"></i>
                <div class="dropdown" style="display: flex">
                  <div
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    class="profile d-flex align-items-center"
                  >
                    <i class="bi bi-person-circle item-header-icon me-2"></i>
                  </div>
                  <ul
                    aria-labelledby="dropdownMenuButton1"
                    class="dropdown-menu"
                    style=""
                  >
                    <router-link to="user-account">
                      <li>
                        <a class="dropdown-item" style="cursor: alias">
                          <i class="bi bi-person"></i> پنل کاربری
                        </a>
                      </li>
                    </router-link>
                    <li>
                      <a
                        class="dropdown-item"
                        @click="userlogout()"
                        style="cursor: alias"
                        ><i class="bi bi-box-arrow-left"></i> خروج
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>
      <div class="container header-items d-none d-md-block">
        <ul class="nav d-flex justify-content-center">
          <router-link to="/">
            <li class="nav-item">
              <a class="nav-link" href="#"> صفحه اصلی</a>
            </li>
          </router-link>
          <li class="nav-item">
            <a class="nav-link" href="#"> دسته بندی</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">درباره ما</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">وبلاگ</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import store from "../../../store/store";
import { logout } from "../../../modules/logout";
import { ref } from "@vue/composition-api";

export default {
  name: "siteheader",
  setup() {
    const loginstatus = ref(store.state.user.user);
    function userlogout() {
      logout();
      loginstatus.value = false;
    }
    return {
      sitename: process.env.MIX_APP_NAME,
      logo: "../assets/VueLur.png",
      sidebar: false,
      loginstatus,
      userlogout,
    };
  },
};
</script>

<style>
</style>