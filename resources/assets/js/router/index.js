import Vue from 'vue'
import Router from 'vue-router'
const world = () => import('../components/world')
const Login = () => import('components/login/login')
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      component: world
    },
    {
      path: '/login',
      component: Login
    }
  ]
})
