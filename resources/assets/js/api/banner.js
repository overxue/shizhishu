import request from './request'

export function getBannerList () {
  return request({
    url: '/api/admin/banners',
    method: 'get'
  })
}

export function showBanner (id, show) {
  return request({
    url: `/api/admin/banners/${id}/onShow`,
    method: 'post',
    data: {
      show
    }
  })
}

export function banner (data) {
  return request({
    url: '/api/admin/banners',
    method: 'post',
    data
  })
}
