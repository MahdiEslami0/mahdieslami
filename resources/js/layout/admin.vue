<template>
  <div>
    <sidebar :adminbar="adminbar" />
    <section class="main" :class="{ active: !adminbar }">
      <header
        class="header d-flex justify-content-between p-3 align-items-center mb-2"

      >
        <div>
          <a href="#" @click="adminbar = !adminbar">
            <i class="toggle-sidebar-icon bi bi-justify fs-3 text-black"></i>
          </a>
        </div>
        <div class="d-flex align-items-center">
          <div class="dropdown">
            <div
              class="dropdown-toggle profile d-flex align-items-center"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <img
                width="45"
                class="img-fluid rounded-circle me-2"
                src="https://www.gravatar.com/avatar/8ea91a667cca5c3ffbc373f73c34821a?s=100"
                alt=""
              />
            </div>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li>
                <router-link to="/">
                  <a class="dropdown-item" style="cursor: alias"
                    ><i class="bi bi-house"></i> نمایش سایت
                  </a>
                </router-link>
              </li>
              <li>
                <a
                  class="dropdown-item"
                  style="cursor: alias"
                  @click="userlogout"
                  ><i class="bi bi-box-arrow-left"></i> خروج
                </a>
              </li>
            </ul>
          </div>
        </div>
      </header>
      <router-view></router-view>
    </section>
  </div>
</template>

<script>
import sidebar from "../component/layout/admin/sidebar.vue";
import { logout } from "../modules/logout";
export default {
  name: "adminlayout",
  data() {
    function userlogout() {
      logout();
      location.replace("/");
    }
    return {
      adminbar: true,
      userlogout,
    };
  },
  components: { sidebar },
};
</script>

<style>
@import url("../../css/admin.css");
</style>