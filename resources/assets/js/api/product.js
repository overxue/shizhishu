import request from './request'

export function createProduct (data) {
  return request({
    url: '/api/admin/product',
    method: 'post',
    data
  })
}

export function product (page, currentPage) {
  return request({
    url: `/api/admin/product?page=${page}&current=${currentPage}`,
    method: 'get'
  })
}
