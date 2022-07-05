<template>
  <div class="container my-5 main-body">
    <div class="row">
      <div class="col-md-3">
        <sidebar :user="user" />
      </div>
      <div class="col-md-9">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import sidebar from "../component/layout/user/sidebar.vue";
import { userinfo } from "../modules/userinfo";
export default {
  name: "panel",
  components: { sidebar },
  setup() {
    return { ...userinfo() };
  },
};
</script>

<style>
</style>