<template>
  <div>
    <section class="admin-sidebar" :class="{ inactive: !adminbar }">
      <div
        class="
          d-flex
          align-items-center
          justify-content-between justify-content-lg-center
        "
      >
        <h4 class="fw-bold d-none d-sm-block">Admin Panel</h4>
        <i class="d-lg-none fs-1 bi bi-x" @click="adminbar = !adminbar"></i>
      </div>
      <div class="mt-4">
        <ul class="list-unstyled">
          <router-link :to="{ name: 'dashbord' }" class="link-none">
            <li class="sidebar-item">
              <p class="sidebar-link">
                <i class="me-2 bi bi-grid-fill"></i>
                <span>داشبورد</span>
              </p>
            </li>
          </router-link>
          <router-link :to="{ name: 'category' }" class="link-none">
            <li class="sidebar-item">
              <p class="sidebar-link">
                <i class="me-2 bi bi-tag-fill"></i>
                <span>دسته بندی</span>
              </p>
            </li>
          </router-link>
          <router-link :to="{ name: 'users' }" class="link-none">
            <li class="sidebar-item">
              <p class="sidebar-link">
                <i class="me-2 bi bi-people-fill"></i>
                <span>مدیریت کاربران</span>
              </p>
            </li>
          </router-link>
        </ul>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: "sidebar",
  props: {
    adminbar: {
      default: () => {
        return [];
      },
    },
  },
};
</script>

<style>
</style>