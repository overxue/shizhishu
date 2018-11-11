import Vue from 'vue'
import Router from 'vue-router'
const Login = () => import('components/login/login')
const Layout = () => import('components/layout/layout')
const Dashboard = () => import('components/dashboard/dashboard')
const Banner = () => import('components/banner/banner')

Vue.use(Router)


export const RouterMap = [
  {
    path: '/',
    component: Layout,
    redirect: 'dashboard',
    children: [
      {
        path: '/dashboard',
        component: Dashboard,
        name: 'dashboard',
        meta: { title: '首页', icon: 'dashboard', noCache: true }
      },
      {
        path: '/banner',
        component: Banner,
        name: 'banner',
        meta: { title: 'Banner', icon: 'banner', noCache: true}
      },
      {
        path: '/test',
        meta: { title: 'text', icon: 'text', noCache: true},
        name: 'test',
        redirect: '/test/abc',
        children: [
          {
            path: '/test/abc',
            component: Banner,
            name: 'abc',
            meta: { title: 'text/abc', icon: 'text', noCache: true}
          }
        ]
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
