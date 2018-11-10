import * as types from './mutation-types'

const mutations = {
  [types.SET_ACCESS_TOKEN] (state, token) {
    state.accessToken = token
  },
  [types.SET_EXPIRES_AT] (state, time) {
    state.expiredAt = time
  },
  [types.SET_USER_INFO] (state, { name, phone }) {
    state.userInfo.name = name
    state.userInfo.phone = phone
  },
  [types.SET_COLLAPSE] (state, bool) {
    state.collapse = bool
  }
}
export default mutations
