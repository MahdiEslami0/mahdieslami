<template>
  <stats class="space-in-mobile" />
</template>

<script>
import stats from "../../component/user/index/stats.vue";
export default {
  name: "dashboard",
  components: {
    stats,
  },
  metaInfo: {
    titleTemplate: `${process.env.MIX_APP_NAME} | پنل کاربری`,
  },
};
</script>

<style>
</style>