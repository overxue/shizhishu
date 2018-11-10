<template>
  <div class="banner-contant">
    <div class="add">
      <el-button type="primary" icon="el-icon-edit" size="medium" @click="addBanner">添加</el-button>
    </div>
    <el-table :data="banners" v-loading="loading" highlight-current-row stripe border style="width: 100%">
      <el-table-column sortable prop="id" label="序号" width="80" align="center"></el-table-column>
      <el-table-column label="图片" width="220" align="center">
        <template slot-scope="scope">
          <img :src="scope.row.imgUrl" width="100" height="40" class="banner-img" @click="imgDetail(scope.row.imgUrl)"/>
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
          <el-tag type="danger" v-else>隐藏</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="操作" min-width="200px">
        <template slot-scope="scope">
          <el-button size="mini" type="danger" @click="show(scope.row.id, false)" v-if="scope.row.show === 1">隐藏</el-button>
          <el-button size="mini" type="primary" @click="show(scope.row.id, true)" v-else>显示</el-button>
        </template>
      </el-table-column>
    </el-table>
    <transition name="fade">
      <div class="banner-detail" v-show="url" @click="hidden">
        <div class="img-wrapper">
          <img :src="url">
        </div>
      </div>
    </transition>
    <el-dialog title="新增Banner" :visible.sync="dialogFormVisible" :modal-append-to-body='false'>
      <el-form :model="createBanner">
        <el-form-item label="图片" label-width="80px">
          <el-upload
            style="width: 300px"
            class="upload-demo"
            drag
            :auto-upload="false"
            action="https://jsonplaceholder.typicode.com/posts/"
            multiple>
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
          </el-upload>
        </el-form-item>
        <el-form-item label="是否显示" label-width="80px">
          <el-switch
            v-model="createBanner.on_show"
            active-color="#13ce66"
            inactive-color="#ff4949">
          </el-switch>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="dialogFormVisible = false">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { getBannerList, showBanner } from 'api/banner'
import dayjs from 'dayjs'
import 'dayjs/locale/zh-cn'
import relativeTime from 'dayjs/plugin/relativeTime'
dayjs.extend(relativeTime)
export default {
  data() {
    return {
      banners: [],
      loading: true,
      url: '',
      dialogFormVisible: false,
      createBanner: {}
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
    },
    show (id, bool) {
      this.loading = true
      showBanner(id, bool).then((res) => {
        this._getBanner()
      })
    },
    imgDetail (url) {
      this.url = url
    },
    hidden () {
      this.url = ''
    },
    addBanner () {
      this.dialogFormVisible = true
    }
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .banner-contant
    padding: 20px
    .add
      margin-bottom: 20px
    .banner-img
      cursor: pointer
    .banner-detail
      position: fixed
      top: 0
      left: 0
      width: 100%
      bottom: 0
      background: hsla(0, 0%, 7%, .7)
      z-index: 10
      &.fade-enter-active, &.fade-leave-active
        transition: all 0.5s
      &.fade-enter, &.fade-leave-active
        opacity: 0
      .img-wrapper
        position: absolute
        top: 50%
        left: 50%
        transform: translate(-50%, -50%)
</style>

<style lang="stylus" rel="stylesheet/stylus">
  .banner-contant
    .el-upload-dragger
      width: 300px
</style>
