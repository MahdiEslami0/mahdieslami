<template>
 <div class="row my-4">
              <div class="col-md-6">
                <button
                  class="btn login-item"
                  style="background-color: #229ed9; color: #fff"
                  disabled
                >
                  ورورد با تلگرام
                </button>
              </div>
              <div class="col-md-6">
                <a href="./auth/google">
                  <button
                    class="btn login-item"
                    style="background-color: #db4437; color: #fff"
                  >
                    ورود با گوگل
                  </button>
                </a>
              </div>
              <div class="col-md-6">
                <a href="./auth/github">
                  <button
                    class="btn login-item"
                    style="background-color: black; color: #fff"
                  >
                    ورود با گیت هاب
                  </button>
                </a>
              </div>
              <div class="col-md-6">
                <button
                  class="btn login-item"
                  style="background-color: #0a66c2; color: #fff"
                  disabled
                >
                  ورود با لینکدین
                </button>
              </div>
            </div>
</template>

<script>
export default {
  name: "social",
};
</script>

<style>
</style>