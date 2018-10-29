<template>
  <div class="navbar">
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
    <div class="right-menu">

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
    }
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .navbar
    display: flex
    position: absolute
    top: 0
    left: 0
    height: 50px
    width: 100%
    line-height: 50px
    border-bottom: 1px solid #f2f2f2
    .hamburger-container
      padding: 0 10px
      cursor: pointer
      .hamburger-icon
        font-size: 20px
      .actived
        display: block
        transform: rotate(90deg)
        transition: .38s
    .breadcrumb-container
      flex: 1
      line-height: 50px
      margin-left: 10px
</style>

<style lang="stylus" rel="stylesheet/stylus">
  .navbar
    .breadcrumb-container
      .el-breadcrumb
        display: inline-block
        line-height: 50px
        /*.el-breadcrumb__inner*/
          /*color: #606266*/
</style>
