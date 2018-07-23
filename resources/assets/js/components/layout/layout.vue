<template>
  <div class="layout">
    <slider class="sider-container"></slider>
    <div class="main-container">
      <navbar></navbar>
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
  components: {
    Slider,
    Navbar
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .layout
    position: relative;
    height: 100%;
    width: 100%;
    .sider-container
      transition: width 0.28s;
      width: 180px
      height: 100%
      position: fixed
      font-size: 0px
      top: 0
      bottom: 0
      left: 0
      overflow: hidden
    .main-container
      position: relative
      min-height: 100%
      transition: margin-left .28s
      margin-left: 180px
</style>
