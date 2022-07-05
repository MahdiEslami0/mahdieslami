import axios from "axios";
import { ref } from "@vue/composition-api";
import { replace } from "lodash";
export function userinfo() {
    const user = ref({});
    axios
        .get("api/user-info", {
            headers: {
                Authorization: `Bearer ${$cookies.get("user_token")}`,
            },
        })
        .then(function (response) {
            user.value = response.data.data.user;
        }).catch(function (error) {
            error
            $cookies.remove("user_token")
            location.replace('/login')
        });
    return { user };
}