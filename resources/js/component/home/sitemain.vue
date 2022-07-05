<template>
  <div class="container my-5 main-body">
    <hr class="main-hr my-5" />
    <h2 class="text-primary fw-bold my-5">
      <i class="bi bi-newspaper text-dark" style="margin-left: 10px"></i>
      آخرین مطالب
    </h2>

    <div class="row">
      <swiper
        :slides-per-view="4"
        :space-between="30"
        :loop="false"
        :breakpoints="swiperOptions.breakpoints"
      >
        <swiper-slide
          v-for="n in 5"
          :key="n"
          class="test"
          :class="{ test_2: true }"
        >
          <div class="col-md-3">
            <div class="card card-post px-2">
              <img
                class="card-img-top card-image mt-2"
                src="https://static.roocket.ir/images/cover/2022/2/6/3PlQ3mofymYiMeBCoEhFioIYRAlLA8oZxjwrNDrX.png"
              />
              <div class="card-body">
                <h4 class="card-title">آموزش لاراول</h4>
                <p class="card-text text-muted fs-9 post-text">
                  لاراول ۹ با تغییرات جدیدی ارائه شده که ما در دوره آشنایی با
                  امکانات لاراول ۹ سعی داریم شما را با این امکانات جدید به شکل
                  کامل آشنا کنیم.
                </p>
              </div>
            </div>
          </div>
        </swiper-slide>
      </swiper>
    </div>
  </div>
</template>

<script>
import { Swiper, SwiperSlide } from "swiper-vue2";
import "swiper/swiper-bundle.css";
export default {
  name: "sitemain",
  components: {
    Swiper,
    SwiperSlide,
  },
  data() {
    return {
      swiperOptions: {
        breakpoints: {
          320: {
            slidesPerView: 1,
            spaceBetween: 0,
          },
          770: {
            slidesPerView: 2,
            spaceBetween: 50,
          },
          992: {
            slidesPerView: 3,
            spaceBetween: 30,
          },
          1400: {
            slidesPerView: 4,
            spaceBetween: 30,
          },
        },
      },
    };
  },
};
</script>

<style>
</style>