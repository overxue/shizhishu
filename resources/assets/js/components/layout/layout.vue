<template>
  <div class="layout" :class="classObj">
    <slider class="sider-container" :isCollapse="isCollapse"></slider>
    <div class="main-container">
      <navbar :isActive="isActive" @toggleClick="toggleSideBar"></navbar>
    </div>
  </div>
</template>

<script>
import Slider from 'base/slider/slider'
import Navbar from 'base/navbar/navbar'

export default {
  data () {
    return {
      isCollapse: false,
      isActive: false
    }
  },
  computed: {
    classObj () {
      return {
        hideSidebar: this.isCollapse
      }
    }
  },
  methods: {
    toggleSideBar () {
      if (this.isActive) {
        this.isActive = false
        this.isCollapse = false
      } else {
        this.isActive = true
        this.isCollapse = true
      }
    }
  },
  components: {
    Slider,
    Navbar
  }
}
</script>

<style lang="stylus" rel="stylesheet/stylus">
  .layout
    position: relative;
    height: 100%;
    width: 100%;
    &.hideSidebar
      .sider-container
        /*width: 64px !important*/
      .main-container
        margin-left: 64px
      /*.el-menu-item*/
        /*padding-left: 5px !important*/
        /*position: relative*/
        /*.el-tooltip*/
          /*padding: 0 5px !important*/
      /*.el-submenu*/
        /*overflow: hidden*/
        /*&>.el-submenu__title*/
          /*padding-left: 5px !important*/
          /*.el-submenu__icon-arrow*/
            /*display: none*/
      /*.el-menu--collapse*/
        /*.el-submenu*/
          /*&>.el-submenu__title*/
            /*&>span*/
              /*height: 0*/
              /*width: 0*/
              /*overflow: hidden*/
              /*visibility: hidden*/
              /*display: inline-block*/
    .sider-container
      transition: width 0.3s;
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
      transition: margin-left 0.28s
      margin-left: 180px
</style>
