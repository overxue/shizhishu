import { RouterMap } from '../router'

const state = {
  // 个人信息
  userInfo: {
    name: '',
    phone: ''
  },
  // access_token
  accessToken: '',
  // 过期时间
  expiredAt: '',
  routers: RouterMap
}

export default state
