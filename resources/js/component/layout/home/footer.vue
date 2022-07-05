<template>
  <div class="container bg-white footer my-5">
    <div class="row p-5">
      <div class="col-md-4">
        <h4>
          دربارمن
          <img
            v-bind:src="logo"
            height="40"
            class="d-inline-block align-text-top"
          />
        </h4>
        <p class="text-muted about-text">
          راکت یکی از پرتلاش‌ترین و بروزترین وبسایت های آموزشی در سطح ایران است
          که همیشه تلاش کرده تا بتواند جدیدترین و بروزترین مقالات و دوره‌های
          آموزشی را در اختیار علاقه‌مندان ایرانی قرار دهد. تبدیل کردن برنامه
        </p>
      </div>
      <div class="col-md-3">
        <h4>بخش های سایت</h4>
        <div class="p-1">
          <p class="list-item-footer">. صفحه اصلی</p>
          <p class="list-item-footer">. مطالب</p>
          <p class="list-item-footer">. درباره ما</p>
          <p class="list-item-footer">. آموزش</p>
        </div>
      </div>
      <div class="col-md-4">
        <h4>ارتباط با من</h4>
        <div class="p-1 mt-4 text-muted">
          <p>
            <span style="float: right">ایمیل:</span
            ><span style="float: left">mahdi.es.work@gmail.com</span>
          </p>
          <br />
          <p>
            <span style="float: right">تلگرام:</span
            ><span style="float: left">@mahdi.es</span>
          </p>
          <br />
          <p>
            <span style="float: right">تلگرام:</span
            ><span style="float: left">@mahdi.es</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "sitefooter",
  data() {
    return {
      sitename: process.env.MIX_APP_NAME,
      logo: "../assets/VueLur.png",
    };
  },
};
</script>

<style>
</style>