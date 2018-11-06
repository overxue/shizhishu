import router from '../../router'
import store from 'store'
import dayjs from 'dayjs'
import { refreshToken } from 'api/login'

const whiteList = ['/login']

router.beforeEach((to, from, next) => {
  if (store.getters.accessToken) {
    console.log(dayjs(store.getters.expiresAt).format('YYYY-MM-DD HH:mm:ss'))
    if (to.path === '/login') {
      next({ path: '/' })
    } else {
      if (dayjs().isAfter(dayjs(store.getters.expiresAt).subtract(2, 'minute'))) {
        // token 过期
        refreshToken().then((res) => {
          store.dispatch('saveToken', { token: res.access_token, time: res.expires_in })
          next()
        }).catch(() => {
          store.dispatch('clearLoginInformation')
          next('/login')
        })
      } else {
        next()
      }
    }
  } else {
    if (whiteList.indexOf(to.path) !== -1) {
      // 在免登录白名单，直接进入
      next()
    } else {
      // 否则全部重定向到登录页
      next('/login')
    }
  }
})
