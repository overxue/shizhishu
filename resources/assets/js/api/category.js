import request from './request'

export function getCategory () {
  return request({
    url: '/api/admin/categories',
    method: 'get'
  })
}
