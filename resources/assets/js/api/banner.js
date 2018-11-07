import request from './request'

export function getBannerList () {
  return request({
    url: '/api/admin/banners',
    method: 'get'
  })
}
