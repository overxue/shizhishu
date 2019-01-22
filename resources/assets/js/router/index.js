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

/**
 * hidden: true                   如果`hidden:true`, 则不会在侧边边栏中显示（默认值为false）
 * alwaysShow: true               如果设置为true，则始终显示根菜单，无论其子路由的长度如何。
 *                                如果未设置alwaysShow，则子级下只能有一个以上的路由
 *                                它将成为嵌套模式，否则不显示根菜单
 * redirect: noredirect           if `redirect:noredirect` will no redirect in the breadcrumb
 * name:'router-name'             the name is used by <keep-alive> (must set!!!)
 * meta : {                       如果设置alwaysShow为true，根菜单也要是设置meta.
    roles: ['admin','editor']     will control the page roles (you can set multiple roles)
    title: 'title'               子菜单和面包屑中显示的名称
    icon: 'svg-name'             侧边栏的图标,
    noCache: true                if true ,the page will no be cached(default is false)
  }
 **/

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
