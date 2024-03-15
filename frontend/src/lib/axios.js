import Axios from 'axios'

const axios = Axios.create({
    baseURL: 'http://localhost:8000/api',
    withCredentials: true,
    withXSRFToken: true,
    xsrfCookieName: 'XSRF-TOKEN',
    xsrfHeaderName: 'X-XSRF-TOKEN',
})

axios.interceptors.response.use(null, (err) => {
    console.log(err)
    const error = {
        status : err.response?.status,
        original : err,
        validation : {},
        message : null
    }

    switch (err.response?.status) {
        case 401:
            error.message = 'Unauthorized, please login again'
            break

        case 403:
            error.message = 'Forbidden, you are not allowed to access this resource'
            break
        case 422:
            for (let field in err.response.data.errors) {
                error.validation[field] = err.response.data.errors[field][0]
            }
            break
        case 500:
            error.message = 'Server error, please try again later'
            break
        default:
            error.message = err.response?.data?.message ?? "Error, please try again later";
        }
    return Promise.reject(error)
})
 
export default axios