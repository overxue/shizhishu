<template>
  <div class="navbar">
    <div class="left-menu">
      <div class="hamburger-container" @click="toggle">
        <i class="iconfont hamburger-icon" :class="{'actived': isCollapse}">&#xe601;</i>
      </div>
      <div class="breadcrumb-container">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
          <el-breadcrumb-item>活动列表</el-breadcrumb-item>
          <el-breadcrumb-item>活动详情</el-breadcrumb-item>
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
          <el-dropdown-item>首页首页首页</el-dropdown-item>
          <el-dropdown-item>设置</el-dropdown-item>
          <el-dropdown-item divided>退出</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    isCollapse: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    toggle () {
      this.$emit('toggle')
    },
    scree () {
      this.$emit('scree')
    }
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .navbar
    display: flex
    justify-content: space-between
    position: absolute
    top: 0
    left: 0
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
          font-size: 20px
        .actived
          display: block
          transform: rotate(90deg)
          transition: .38s
      .breadcrumb-container
        display: inline-block
        vertical-align: top
        margin-left: 10px
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
