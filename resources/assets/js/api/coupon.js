import request from './request'

export function getCoupon (page, currentPage) {
  return request({
    url: `/api/admin/coupons?page=${page}&current=${currentPage}`,
    method: 'get'
  })
}

export function createCoupon (coupon) {
  return request({
    url: '/api/admin/coupons',
    method: 'post',
    data: coupon
  })
}
