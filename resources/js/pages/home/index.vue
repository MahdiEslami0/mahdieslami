<template>
  <div>
    <intro />
    <sitemain />
  </div>
</template>

<script>
import sitemain from "../../component/home/sitemain.vue";
import intro from "../../component/home/intro.vue";
export default {
  name: "index",
  metaInfo: {
    titleTemplate: "%s | صفحه اصلی",
  },
  components: {
    intro,
    sitemain,
  },
};
</script>

<style>
</style>