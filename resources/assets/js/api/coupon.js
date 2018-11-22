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

export function updateCoupon (coupon) {
  return request({
    url: `/api/admin/coupons/${coupon.id}`,
    method: 'patch',
    data: coupon
  })
}

export function delCoupon (id) {
  return request({
    url: `/api/admin/coupons/${id}`,
    method: 'delete'
  })
}
