import Vue from 'vue'
import Router from 'vue-router'
const Login = () => import('components/login/login')
const Layout = () => import('components/layout/layout')
const Dashboard = () => import('components/dashboard/dashboard')
const Banner = () => import('components/banner/banner')

Vue.use(Router)


export const constantRouterMap = [
  {
    path: '/',
    component: Layout,
    redirect: 'dashboard',
    children: [
      {
        path: '/dashboard',
        component: Dashboard,
        name: 'dashboard',
        meta: { title: '首页', icon: 'dashboard' }
      }
    ]
  },
  {
    path: '/login',
    component: Login,
    hidden: true
  }
]

export default new Router({
  routes: constantRouterMap
})

export const asyncRouterMap = [
  {
    path: '/banner',
    component: Layout,
    redirect: '/banner/index',
    children: [
      {
        path: '/banner/index',
        component: Banner,
        name: 'bannerIndex',
        meta: { title: 'Banner', icon: 'banner'}
      }
    ]
  }
  // {
  //   path: '/test',
  //   component: Layout,
  //   meta: { title: 'test', icon: 'test'},
  //   children: [
  //     {
  //       path: '/text/index',
  //       component: Banner,
  //       name: 'ha',
  //       meta: { 'title': 'test/index'}
  //     },
  //     {
  //       path: '/text/first',
  //       component: Dashboard,
  //       name: 'dd',
  //       meta: { 'title': 'test/first' }
  //     }
  //   ]
  // },
  // {
  //   path: '/t',
  //   component: Layout,
  //   meta: { title: 't', icon: 't'},
  //   alwaysShow: true,
  //   children: [
  //     {
  //       path: '/t/index',
  //       component: Banner,
  //       meta: { title: 't/index'}
  //     }
  //   ]
  // }
]
