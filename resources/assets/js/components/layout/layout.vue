<template>
  <div class="layout">
    <div class="sidebar-container" :class="{'hide-slider': isCollapse}">
      <slider :isCollapse="isCollapse"></slider>
    </div>
    <div class="main-container" :class="{'hide-slider': isCollapse}">
      <navbar @toggle="toggle" @scree="scree" :isCollapse="isCollapse"></navbar>
      <tags-view></tags-view>
      <div class="app-main">
        <transition name="fade-transform" mode="out-in">
          <keep-alive>
            <router-view></router-view>
          </keep-alive>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
import Slider from 'base/slider/slider'
import Navbar from 'base/navbar/navbar'
import TagsView from 'base/tags-view/tags-view'
import screenfull from 'screenfull'

export default {
  data () {
    return {
      isCollapse: false
    }
  },
  methods: {
    toggle () {
      this.isCollapse = !this.isCollapse
    },
    scree () {
      if (!screenfull.enabled) {
        this.$message.warning('浏览器不支持全屏')
        return false
      }
      screenfull.toggle()
    }
  },
  components: {
    Slider,
    Navbar,
    TagsView
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .layout
    position: absolute
    top: 0
    left: 0
    right: 0
    bottom: 0
    overflow: hidden
    .sidebar-container
      position: fixed
      top: 0
      left: 0
      width: 180px
      bottom: 0
      background: #304156
      transition: width .28s
      &.hide-slider
        width: 64px
    .main-container
      position: fixed
      left: 180px
      right: 0
      top: 0
      bottom: 0
      background: #fff
      transition: left .28s
      &.hide-slider
        left: 64px
    .app-main
      position: absolute
      top: 87px
      right: 0
      left: 0
      bottom: 0
      background: #f0f2f5
      &.fade-transform-leave-active, &.fade-transform-enter-active
        transition: all .5s
      &.fade-transform-enter
        opacity: 0
        transform: translateX(-30px)
      &.fade-transform-leave-to
        opacity: 0
        transform: translateX(30px)
</style>
