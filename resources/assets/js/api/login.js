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

