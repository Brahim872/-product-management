import axios from 'axios';
import { useRouter } from 'vue-router';

axios.defaults.baseURL = "/";

// Set up Axios with a base URL and headers
const instance = axios.create({
    baseURL: axios.defaults.baseURL, // Replace with your API base URL
    headers: {
        'Authorization': 'Bearer ' + localStorage.getItem('token'),
    },
});

// Use the setup function to get the router instance
const router = useRouter();

axios.interceptors.response.use(
    (response) => {
        console.log("==> ", { response });
        return response;
    },
    (error) => {
        console.log("==> ", error.response);
        if (error.response && error.response.status === 401) {
            localStorage.removeItem('token')
            window.location.href = "/auth/login"
        }
        return Promise.reject(error);
    },

);

export default instance;
