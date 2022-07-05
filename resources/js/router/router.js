import Vue from "vue";
import VueRouter from "vue-router";
import routes from './routes'
import axios from "axios";
Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((routeTo, from, next) => {
    if (routeTo.meta.login && $cookies.get("user_token") !== null) {
        next('/')
    } else {
        next()
    }
    if (routeTo.meta.admin || routeTo.matched.some(parent => parent.meta.admin)) {
        axios
            .get(`/api/rolecheck`, {
                headers: {
                    Authorization: `Bearer ${$cookies.get("user_token")}`,
                },
            })
            .then(function (response) {
                if (response.data.admin == true) {
                    next()
                } else {
                    next('404')
                }
            })
            .catch(function (error) {
                next('404')
            });
    } else {
        next()
    }
})


export default router;