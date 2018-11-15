import router from '../../router'
import dayjs from 'dayjs'
import store from '../../store'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
import { refreshToken, getUserInfo } from 'api/login'

NProgress.configure({ showSpinner: false })

const whiteList = ['/login']

router.beforeEach((to, from, next) => {
  NProgress.start()
  if (store.getters.accessToken) {
    // 有 token
    console.log(dayjs(store.getters.expiresAt).format('YYYY-MM-DD HH:mm:ss'))
    if (to.path === '/login') {
      // 有 token 进入登录页面，重定向到首页
      next({ path: '/' })
      NProgress.done()
    } else {
      if (dayjs().isAfter(dayjs(store.getters.expiresAt).subtract(2, 'minute'))) {
        // token 过期，请求后端接口刷新 token
        refreshToken().then((res) => {
          store.dispatch('saveToken', { token: res.access_token, time: res.expires_in })
          next()
        }).catch(() => {
          store.dispatch('clearLoginInformation')
          next('/login')
        })
      } else {
        if (!store.getters.userName){
          getUserInfo().then((res) => {
            store.dispatch('saveUserInfo', { name: res.name, phone: res.phone}).then(() => {
              // 动态生成理由
              store.dispatch('GenerateRoutes').then(() => {
                // 动态添加可访问路由表
                router.addRoutes(store.getters.addRouters)
                next()
              })
            })
          })
        } else {
          next()
        }
      }
    }
  } else {
    // 没有token
    if (whiteList.indexOf(to.path) !== -1) {
      // 在免登录白名单，直接进入
      next()
    } else {
      // 否则全部重定向到登录页
      next('/login')
      NProgress.done()
    }
  }
})

router.afterEach(() => {
  NProgress.done()
})
