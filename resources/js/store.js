import { reactive } from 'vue'
import Auth from "./helpers/auth.js";

export const userStore = reactive({
    userData: {
        username: '',
        email: '',
        role: '',
    },

    async getUser(){
        if(Auth.check() && this.userData.username === '') {
          await axios
                .get('/api/v1/user-data', [], {
                    "headers": {
                        "Authorization": "Bearer " + Auth.token
                    }
                })
                .then(response => {
                    this.userData = {
                        username: response.data.username,
                        email: response.data.email,
                        role: response.data.role,
                    }
                })
                .catch((error) => {
                    console.log(error.response.data.errors);
                });
        }
    }

})

export const store = reactive({
    count: 0,
    increment() {
        this.count++
    }
})
