import Vue from 'vue'
import axios from "axios";
import Swal from "sweetalert2";
Vue.use(require('vue-cookies'))
import router from '../router/router'
export function logout() {
    const token = $cookies.get("user_token");
    $cookies.remove("user_token")
    axios.get(`api/logout`, {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    }).then(function (response) {
        response
        Swal.fire({
            icon: "success",
            title: "با موفقیت خارج شدید",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        router.push('/')
    }).catch(function (error) {
        Swal.fire({
            icon: "error",
            title: "خطا در انجام عملیات",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    })
}