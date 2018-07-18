import Vue from 'vue'
import Router from 'vue-router'
const world = () => import('../components/world')
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      component: world
    }
  ]
})
