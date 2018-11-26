<template>
  <div class="navbar">
    <div class="left-menu">
      <div class="hamburger-container" @click="toggle">
        <i class="iconfont hamburger-icon" :class="{'actived': isCollapse}">&#xe601;</i>
      </div>
      <div class="breadcrumb-container">
        <el-breadcrumb separator="/">
          <transition-group name="breadcrumb">
           <el-breadcrumb-item v-for="(item, index) in levelList" :key="item.path">
             <span v-if="item.redirect==='noredirect'||index==levelList.length-1" class="no-redirect">{{item.meta.title}}</span>
             <a v-else @click.prevent="handleLink(item)">{{item.meta.title}}</a>
           </el-breadcrumb-item>
          </transition-group>
        </el-breadcrumb>
      </div>
    </div>
    <div class="right-menu">

      <div class="screenfull" @click="scree">
        <el-tooltip effect="dark" content="全屏" placement="bottom">
          <span class="iconfont screenfull-icon">&#xe615;</span>
        </el-tooltip>
      </div>

      <el-dropdown class="avatar-container" trigger="click">
        <div class="avatar-wrapper">
          <img class="user-avatar" width="40" height="40" src="https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif?imageView2/1/w/80/h/80">
          <i class="el-icon-caret-bottom"></i>
        </div>
        <el-dropdown-menu slot="dropdown">
          <router-link to="/">
            <el-dropdown-item>
              首页
            </el-dropdown-item>
          </router-link>
          <a target='_blank' href="https://github.com/overxue/shizhishu">
            <el-dropdown-item>
              Github
            </el-dropdown-item>
          </a>
          <el-dropdown-item>设置</el-dropdown-item>
          <el-dropdown-item divided>
            <span @click="logout" style="display:block;">退出</span>
          </el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </div>
  </div>
</template>

<script>
import { loginOut } from 'api/login'
import { mapActions } from 'vuex'
export default {
  props: {
    isCollapse: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      levelList: []
    }
  },
  created () {
    this.getBreadcrumb()
  },
  methods: {
    toggle () {
      this.$emit('toggle')
    },
    scree () {
      this.$emit('scree')
    },
    getBreadcrumb () {
      let matched = this.$route.matched.filter(item => item.name)
      const first = matched[0]
      if (first && first.name !== 'dashboard') {
        matched = [{ path: '/dashboard', meta: { title: '首页' }}].concat(matched)
      }
      this.levelList = matched
    },
    logout () {
      loginOut().then(() => {
        this.clearLoginInformation().then(() => {
          location.reload()
        })
      })
    },
    handleLink(item) {
      // const { redirect, path } = item
      // if (redirect) {
      //   this.$router.push(redirect)
      //   return
      // }
      this.$router.push(item.path)
    },
    ...mapActions({
      clearLoginInformation: 'clearLoginInformation'
    })
  },
  watch: {
    $route () {
      this.getBreadcrumb()
    }
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .navbar
    display: flex
    justify-content: space-between
    /*position: absolute*/
    /*top: 0*/
    /*left: 0*/
    height: 50px
    width: 100%
    border-bottom: 1px solid #f2f2f2
    .left-menu
      .hamburger-container
        display: inline-block
        vertical-align: top
        line-height: 50px
        padding: 0 10px
        cursor: pointer
        .hamburger-icon
          display: block
          font-size: 20px
          transform: rotate(0deg)
          transition: 0.38s
          &.actived
            transform: rotate(90deg)
      .breadcrumb-container
        display: inline-block
        vertical-align: top
        margin-left: 10px
        .breadcrumb-enter-active, .breadcrumb-leave-active
          transition: all .5s
        .breadcrumb-enter, .breadcrumb-leave-active
          opacity: 0
          transform: translateX(20px)
        .breadcrumb-move
          transition: all .5s
        .breadcrumb-leave-active
          position: absolute
    .right-menu
      line-height: 50px
      .screenfull
        display: inline-block
        vertical-align: top
        padding: 0 10px
        cursor: pointer
        .screenfull-icon
          font-size: 20px
          font-weight: 700
      .avatar-container
        height: 50px
        margin: 0 30px 0 10px
        line-height: 0
        .avatar-wrapper
          cursor: pointer
          margin-top: 5px
          position: relative
          .user-avatar
            border-radius: 10px
          .el-icon-caret-bottom
            position: absolute
            right: -20px
            top: 25px
            font-size: 12px
</style>

<style lang="stylus" rel="stylesheet/stylus">
  .navbar
    .breadcrumb-container
      .el-breadcrumb
        display: inline-block
        line-height: 50px
</style>
