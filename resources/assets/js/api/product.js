import request from './request'

export function createProduct (data) {
  return request({
    url: '/api/admin/products',
    method: 'post',
    data
  })
}

export function product (page, currentPage) {
  return request({
    url: `/api/admin/products?page=${page}&current=${currentPage}&include=category`,
    method: 'get'
  })
}

export function delProduct (id) {
  return request({
    url: `/api/admin/products/${id}`,
    method: 'delete'
  })
}
