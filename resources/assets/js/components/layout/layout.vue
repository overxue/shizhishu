<template>
  <div class="layout">
    <div class="sidebar-container" :class="{'hide-slider': collapse}">
      <slider :isCollapse="collapse"></slider>
    </div>
    <div class="main-container" :class="{'hide-slider': collapse}">
      <navbar @toggle="toggle" @scree="scree" :isCollapse="collapse"></navbar>
      <tags-view></tags-view>
      <div class="app-main">
        <!--<div class="app-content">-->
          <transition name="fade-transform" mode="out-in">
            <!-- <keep-alive> -->
            <router-view></router-view>
            <!-- </keep-alive> -->
          </transition>
        <!--</div>-->
      </div>
    </div>
  </div>
</template>

<script>
import Slider from 'base/slider/slider'
import Navbar from 'base/navbar/navbar'
import TagsView from 'base/tags-view/tags-view'
import screenfull from 'screenfull'
import { mapGetters, mapActions } from 'vuex'

export default {
  computed: {
    ...mapGetters([
      'collapse'
    ])
  },
  created () {
  },
  methods: {
    toggle () {
      this.saveIsCollapse(!this.collapse)
    },
    scree () {
      if (!screenfull.enabled) {
        this.$message.warning('浏览器不支持全屏')
        return false
      }
      screenfull.toggle()
    },
    ...mapActions([
      'saveIsCollapse'
    ])
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
    position: relative
    height: 100%
    width: 100%
    .sidebar-container
      position: fixed
      top: 0
      left: 0
      width: 180px
      bottom: 0
      background: #304156
      transition: width .28s
      z-index: 1
      &.hide-slider
        width: 64px
    .main-container
      position: relative
      height: 100%
      overflow: hidden
      margin-left: 180px
      background: #fff
      transition: margin-left .28s
      &.hide-slider
        margin-left: 64px
      .app-main
        position: absolute
        top: 87px
        right: 0
        left: 0
        bottom: 0
        background: #f0f2f5
        .fade-transform-leave-active, .fade-transform-enter-active
          transition: all .5s
        .fade-transform-enter
          opacity: 0
          transform: translateX(-30px)
        .fade-transform-leave-to
          opacity: 0
          transform: translateX(30px)
</style>
