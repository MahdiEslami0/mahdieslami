<template>
  <div class="container my-3 intro">
    <div class="row">
      <div class="col-md-6">
        <h2 class="intro-title fw-bold">
          وبسایت شخصی <span class="text-primary">مهدی اسلامی</span>
        </h2>
        <p class="text-muted fs-4 mt-5">
          Full stack devloper | برنامه نویس فرانت اند و بک اند
        </p>
      </div>
      <div class="col-md-6">
        <img
          :src="image"
          class="intro-image img-fluid  d-none d-md-block"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "intro",
  data() {
    return {
      image: "/images/undraw_nuxt_js_0fq9.png",
    };
  },
};
</script>

<style>
</style>