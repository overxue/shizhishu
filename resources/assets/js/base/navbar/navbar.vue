<template>
  <el-menu class="navbar" mode="horizontal">
    <div class="hamburger-container" @click="toggleClick">
      <i class="iconfont icon-hidden">&#xe601;</i>
    </div>
  </el-menu>
</template>

<script>
export default {
  methods: {
    toggleClick: {

    }
  }
}
</script>

<style lang="stylus" rel="stylesheet/stylus" scoped>
  .navbar
    height: 50px
    line-height: 50px
    .hamburger-container
      line-height: 58px
      height: 50px
      float: left
      padding: 0 10px
      .icon-hidden
        cursor: pointer
        font-size: 20px
        transform: rotate(90deg)
        transition: 0.38s
        transform-origin: 50% 50%
</style>
