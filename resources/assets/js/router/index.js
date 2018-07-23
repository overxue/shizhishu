import Vue from 'vue'
import Router from 'vue-router'
const Login = () => import('components/login/login')
const Layout = () => import('components/layout/layout')
// const Dashboard = () => import('components/dashboard/dashboard')
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      component: Layout
      // redirect: 'dashboard',
      // children: [
      //   {
      //     path: 'dashboard',
      //     component: Dashboard
      //   }
      // ]
    },
    {
      path: '/login',
      component: Login
    }
  ]
})
