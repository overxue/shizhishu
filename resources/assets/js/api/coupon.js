import request from './request'

export function getCoupon () {
  return request({
    url: '/api/admin/coupons',
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
