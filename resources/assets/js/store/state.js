import { RouterMap } from '../router'
import { loadAccessToken, loadExpiresIn } from 'common/js/cache'

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
  routers: RouterMap
}

export default state
