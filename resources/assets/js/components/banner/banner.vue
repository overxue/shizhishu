<template>
  <div class="banner-contant">
    <div class="add">
      <el-button type="primary" icon="el-icon-circle-plus-outline" size="medium" @click="dialogFormVisible = true">添加</el-button>
    </div>
    <el-table :data="banners" v-loading="loading" highlight-current-row stripe border style="width: 100%">
      <el-table-column sortable prop="id" label="序号" width="80" align="center"></el-table-column>
      <el-table-column label="图片" width="220" align="center">
        <template slot-scope="scope">
          <img :src="scope.row.imgUrl" width="100" height="40" class="banner-img" @click="url = scope.row.imgUrl"/>
        </template>
      </el-table-column>
      <el-table-column label="创建时间" width="160" align="center">
        <template slot-scope="scope">
          <span>{{scope.row.created_at}}</span>
        </template>
      </el-table-column>
      <el-table-column label="状态" width="100" align="center">
        <template slot-scope="scope">
          <el-tag :type="scope.row.show | stateFilter" size="medium"  v-text="scope.row.show ? '显示' : '隐藏'"></el-tag>
        </template>
      </el-table-column>
      <el-table-column label="操作" min-width="200px">
        <template slot-scope="scope">
          <el-button icon="el-icon-view" size="small" :type="scope.row.show | typeFilter" @click="show(scope.row.id, !scope.row.show)" v-text="scope.row.show ? '隐藏' : '显示'"></el-button>
          <el-button icon="el-icon-delete" size="small" type="danger" @click="del(scope.row.id)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <transition name="fade">
      <div class="banner-detail" v-show="url" @click="url = ''">
        <div class="img-wrapper">
          <img :src="url">
        </div>
      </div>
    </transition>
    <el-dialog title="新增Banner" :visible.sync="dialogFormVisible">
      <el-form :model="createBanner" :rules="rules" ref="banner">
        <el-form-item label="图片" label-width="80px" prop="imgUrl">
          <el-upload
            style="width: 300px"
            class="upload-demo"
            drag
            action="/api/images"
            :on-success="handleSuccess"
            :on-remove="handleRemove"
            :file-list="fileList"
            :limit="1"
            name="image"
            :data="{'type': 'banner'}"
            >
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
          </el-upload>
          <el-input v-model="createBanner.imgUrl" type="hidden" style="display: none"></el-input>
        </el-form-item>
        <el-form-item label="是否显示" label-width="80px" prop="on_show">
          <el-switch
            v-model="createBanner.on_show"
            active-color="#13ce66"
            inactive-color="#ff4949">
          </el-switch>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="reset">重 置</el-button>
        <el-button type="primary" @click="createSubmit">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { getBannerList, showBanner, banner, delBanner } from 'api/banner'
import dayjs from 'dayjs'
// import 'dayjs/locale/zh-cn'
// import relativeTime from 'dayjs/plugin/relativeTime'
// dayjs.extend(relativeTime)
export default {
  data() {
    return {
      banners: [],
      loading: true,
      url: '',
      dialogFormVisible: false,
      createBanner: {
        on_show: false,
        imgUrl: ''
      },
      rules: {
        imgUrl: [{required: true, message: '请上传图片', trigger: 'change'}]
      },
      fileList: []
    }
  },
  filters: {
    stateFilter (state) {
      return state ? 'primary' : 'warning'
    },
    typeFilter (type) {
      return type ? 'warning' : 'primary'
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
    // time (time) {
    //   return dayjs(time).locale('zh-cn').fromNow()
    // },
    show (id, bool) {
      this.loading = true
      showBanner(id, bool).then((res) => {
        this._getBanner()
      })
    },
    handleSuccess (res) {
      this.createBanner.imgUrl = res.path
    },
    handleRemove () {
      this.createBanner.imgUrl = ''
    },
    reset () {
      this.$refs['banner'].resetFields()
      this.fileList = []
    },
    createSubmit () {
      this.$refs['banner'].validate((valid) => {
        if (!valid) return
        banner(this.createBanner).then(res => {
          this._getBanner()
          this.reset()
          this.dialogFormVisible = false
        })
      })
    },
    del (id) {
      this.$confirm('此操作将永久删除该banner, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        delBanner(id).then(() => {
          this._getBanner()
        })
      }).catch(() => {})
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
