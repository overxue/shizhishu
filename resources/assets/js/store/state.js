import { RouterMap } from '../router'
import { loadAccessToken, loadExpiresIn, loadCollapse } from 'common/js/cache'

const state = {
  // 个人信息
  userInfo: {
    name: '',
    phone: ''
  },
  // access_token
  accessToken: loadAccessToken(),
  // 过期时间
  expiredAt: loadExpiresIn(),
  // 路由
  routers: RouterMap,
  // 左侧菜单栏是否折叠
  collapse: loadCollapse(),
  // tags-view
  visitedViews: []
}

export default state
