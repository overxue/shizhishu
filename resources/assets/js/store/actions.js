import * as types from './mutation-types'
import { saveAccessToken, saveExpiresIn, clearExpiresIn, clearAccessToken, saveCollapse } from 'common/js/cache'
import dayjs from 'dayjs'

export const saveToken = function ({ commit }, { token, time }) {
  let times = dayjs().add(time, 'second').valueOf()
  commit(types.SET_ACCESS_TOKEN, saveAccessToken(token))
  commit(types.SET_EXPIRES_AT, saveExpiresIn(times))
}

export const saveUserInfo = function ({ commit }, { name, phone }) {
  commit(types.SET_USER_INFO, { name, phone })
}

export const clearLoginInformation = function ({ commit }) {
  commit(types.SET_USER_INFO, { name: '', phone: '' })
  commit(types.SET_EXPIRES_AT, clearExpiresIn())
  commit(types.SET_ACCESS_TOKEN, clearAccessToken())
}

export const saveIsCollapse = function ({ commit }, bool ) {
  commit(types.SET_COLLAPSE, saveCollapse(bool))
}

export const saveVisitedViews = function ({ commit, state }, view) {
  let tags = state.visitedViews.slice()
  if (tags.some(v => v.path === view.path)) return
  tags.push(Object.assign({}, {
    title: view.meta.title || 'no-name',
    path: view.path
  }))
  commit(types.SET_VISITED_VIEWS, tags)
}

export const delVisitedViews = function ({ commit, state }, index) {
  let tags = state.visitedViews.slice()
  tags.splice(index, 1)
  commit(types.SET_VISITED_VIEWS, tags)
}
