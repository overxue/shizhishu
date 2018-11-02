import Vue from 'vue'
import Router from 'vue-router'
const Login = () => import('components/login/login')
const Layout = () => import('components/layout/layout')
const Dashboard = () => import('components/dashboard/dashboard')

Vue.use(Router)


export const RouterMap = [
  {
    path: '/',
    component: Layout,
    redirect: 'dashboard',
    children: [
      {
        path: 'dashboard',
        component: Dashboard,
        name: 'dashboard',
        meta: { title: '首页', icon: 'dashboard', noCache: true }
      },
      {
        path: '/hah',
        component: Dashboard
      }
    ]
  },
  {
    path: '/login',
    component: Login
  }
]

export default new Router({
  routes: RouterMap
})
