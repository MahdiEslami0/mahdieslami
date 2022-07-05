export const namespaced = true;
import Vue from 'vue'
import { ref } from "@vue/composition-api";
import VueCompositionApi from '@vue/composition-api';
Vue.use(VueCompositionApi);
Vue.use(require('vue-cookies'))



const token = ref(false);

if ($cookies.get("user_token") === null) {
    token.value = false;
} else {
    token.value = true;
}


export const state = {
    user: token.value,
};


export const mutations = {
    LOGIN(state) {
        state.user = true;
    },
    LOGOUT(state) {
        state.user = false;
    },
}


export const actions = {
    login({ commit }) {
        commit('LOGIN')
    },
    logout({ commit }) {
        commit('LOGOUT')
    },
};

