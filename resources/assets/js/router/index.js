import Vue from 'vue'
import Router from 'vue-router'
const Login = () => import('components/login/login')
const Layout = () => import('components/layout/layout')
const Dashboard = () => import('components/dashboard/dashboard')
const Banner = () => import('components/banner/banner')
const Coupon = () => import('components/coupon/coupon')
const CreateProduct = () => import('components/product/create')
const Product = () => import('components/product/product')
const Order = () => import('components/order/order')

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
  },
  {
    path: '/coupon',
    component: Layout,
    redirect: '/coupon/index',
    children: [
      {
        path: '/coupon/index',
        component: Coupon,
        name: 'Coupon',
        meta: { 'title': '优惠券', icon: 'coupon' }
      }
    ]
  },
  {
    path: '/product',
    component: Layout,
    meta: { title: '商品管理', icon: 'product' },
    name: 'product',
    redirect: '/product/index',
    alwaysShow: true,
    children: [
      {
        path: '/product/create',
        component: CreateProduct,
        name: 'CreateProduct',
        meta: {'title': '新增商品'}
      },
      {
        path: '/product/index',
        component: Product,
        name: 'ProductIndex',
        meta: { title: '商品列表' }
      }
    ]
  },
  {
    path: '/order',
    component: Layout,
    redirect: '/order/index',
    children: [
      {
        path: '/order/index',
        component: Order,
        name: 'OrderIndex',
        meta: { title: '订单管理', icon: 'banner'}
      }
    ]
  }
]
