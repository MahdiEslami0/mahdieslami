<template>
  <div class="user-sidebar sticky-top">
    <h3 class="text-center">{{ user.user_name }}</h3>
    <p class="text-center text-muted">{{ user.user_email }}</p>
    <ul class="list-unstyled">
      <router-link to="/user-account" class="link-none">
        <li class="sidebar-item">
          <p class="sidebar-link user-item">
            <i class="bi bi-speedometer me-2 text-black"></i>
            <span class="text-black">داشبورد</span>
          </p>
        </li>
      </router-link>
      <router-link to="profile">
        <li class="sidebar-item">
          <p class="sidebar-link user-item">
            <i class="bi bi-person-check-fill me-2 text-black"></i>
            <span class="text-black">اطلاعات کاربری</span>
          </p>
        </li>
      </router-link>
      <router-link
        to="admin"
        class="link-none text-black"
        v-if="user.user_role > 1"
      >
        <li class="sidebar-item">
          <p class="sidebar-link user-item">
            <i class="me-2 bi bi-grid-fill text-black"></i>
            <span>پنل مدیریت سایت</span>
          </p>
        </li>
      </router-link>
    </ul>
  </div>
</template>

<script>
export default {
  name: "sidebar",
  props: {
    user: {
      default: () => {
        return [];
      },
    },
  },
};
</script>

<style>
</style>