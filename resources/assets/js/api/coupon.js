import request from './request'

export function getCoupon () {
  return request({
    url: '/api/admin/coupons',
    method: 'get'
  })
}
