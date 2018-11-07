<template>
  <div class="banner-contant">
    <el-table :data="banners" v-loading="loading" highlight-current-row stripe border style="width: 100%">
      <el-table-column sortable prop="id" label="序号" width="80" align="center"></el-table-column>
      <el-table-column label="图片" width="220" align="center">
        <template slot-scope="scope">
          <img :src="scope.row.imgUrl" width="100" height="40"/>
        </template>
      </el-table-column>
      <el-table-column label="创建时间" width="100" align="center">
        <template slot-scope="scope">
          <span>{{time(scope.row.created_at)}}</span>
        </template>
      </el-table-column>
      <el-table-column label="状态" width="100" align="center">
        <template slot-scope="scope">
          <el-tag type="success" v-if="scope.row.show">显示</el-tag>
          <el-button type="danger" v-else>隐藏</el-button>
        </template>
      </el-table-column>
      <el-table-column label="操作" min-width="200px">
        <template slot-scope="scope">
          <el-button size="mini" type="danger">隐藏</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { getBannerList } from 'api/banner'
import dayjs from 'dayjs'
import 'dayjs/locale/zh-cn'
import relativeTime from 'dayjs/plugin/relativeTime'
dayjs.extend(relativeTime)
export default {
  data() {
    return {
      banners: [],
      loading: true
    }
  },
  created () {
    this._getBanner()
  },
  methods: {
    _getBanner () {
      this.loading = true
      getBannerList().then((res) => {
        this.banners = res.data
        this.loading = false
      })
    },
    time (time) {
      return dayjs(time).locale('zh-cn').fromNow()
    }
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .banner-contant
    padding: 20px
</style>
