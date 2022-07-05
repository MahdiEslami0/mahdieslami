<template>
  <div>
    <siteheader />
    <router-view></router-view>
    <sitefooter />
  </div>
</template>

<script>
import siteheader from "../component/layout/home/siteheader.vue";
import sitefooter from "../component/layout/home/footer.vue";
export default {
  name: "home",
  metaInfo: {
    title: process.env.MIX_APP_NAME,
  },
  components: {
    siteheader,
    sitefooter,
  },
};
</script>

<style>
</style>