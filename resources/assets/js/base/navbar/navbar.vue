<template>
  <el-menu class="navbar" mode="horizontal">
    <div class="hamburger-container" @click="toggleClick" :class="{'is-active' : isActive}">
      <i class="iconfont icon-hidden">&#xe601;</i>
    </div>
  </el-menu>
</template>

<script>
export default {
  props: {
    isActive: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    toggleClick () {
      this.$emit('toggleClick');
    }
  }
}
</script>

<style lang="stylus" rel="stylesheet/stylus" scoped>
  .navbar
    height: 50px
    line-height: 50px
    .hamburger-container
      line-height: 55px
      height: 50px
      float: left
      padding: 0 10px
      transform: rotate(0deg)
      transition: 0.38s
      transform-origin: 50% 50%
      outline: none
      &.is-active
        transform: rotate(90deg)
      .icon-hidden
        cursor: pointer
        font-size: 20px
</style>
