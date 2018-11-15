import request from './request'

export function login (username, password) {
  return request({
    url: '/api/authorizations',
    method: 'post',
    data: {
      username,
      password
    }
  })
}

export function refreshToken () {
  return request({
    url: '/api/authorizations/current',
    method: 'put'
  })
}

export function loginOut () {
  return request({
    url: '/api/authorizations/current',
    method: 'delete'
  })
}

export function getUserInfo () {
  return request({
    url: '/api/user',
    method: 'get'
  })
}
