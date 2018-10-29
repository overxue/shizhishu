<template>
  <div class="layout">
    <div class="sidebar-container" :class="{'hide-slider': isCollapse}">
      <slider :isCollapse="isCollapse"></slider>
    </div>
    <div class="main-container" :class="{'hide-slider': isCollapse}">
      <navbar @toggle="toggle" :isCollapse="isCollapse"></navbar>
    </div>
  </div>
</template>

<script>
import Slider from 'base/slider/slider'
import Navbar from 'base/navbar/navbar'

export default {
  data () {
    return {
      isCollapse: false
    }
  },
  methods: {
    toggle () {
      this.isCollapse = !this.isCollapse
    }
  },
  components: {
    Slider,
    Navbar
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .layout
    position: absolute
    top: 0
    left: 0
    width: 100%
    bottom: 0
    .sidebar-container, .main-container
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
      left: 180px
      width: 100%
      background: #fff
      transition: left .28s
      &.hide-slider
        left: 64px
        width: 100%
</style>
