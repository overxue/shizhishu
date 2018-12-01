import request from './request'

export function createProduct (data) {
  return request({
    url: '/api/admin/product',
    method: 'post',
    data
  })
}
