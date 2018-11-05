import axios from 'axios'
import { http } from './config'

// 创建 axios 实例
const service = axios.create({
  baseUrl: http,
  timeout: 5000
})

// request 拦截器
service.interceptors.request.use((config) => {
  return config
}, (error) => {
  console.log(error)
  Promise.reject(error)
})

// respone拦截器
service.interceptors.response.use((response) => {
  if (response.status === 200 || response.status === 201 || response.status === 204) {
    return response.data
  }
}, (error) => {
  let err = error.response
  console.log(err)
  return Promise.reject(error)
  // return new Promise(() => {})
})

export default service
