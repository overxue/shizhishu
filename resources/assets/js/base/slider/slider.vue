<template>
  <el-scrollbar style="height: 100%" class="slider">
    <el-menu
      default-active="1"
      background-color="#304156"
      text-color="#bfcbd9"
      active-text-color="#409EFF"
      :collapse="isCollapse"
    >
      <!--<el-submenu index="1">-->
      <!--<template slot="title">-->
        <!--<i class="el-icon-location"></i>-->
        <!--<span slot="title">导航一</span>-->
      <!--</template>-->
      <!--<el-menu-item index="1-1">选项1</el-menu-item>-->
      <!--<el-menu-item index="1-2">选项2</el-menu-item>-->
      <!--<el-menu-item index="1-3">选项3</el-menu-item>-->
    <!--</el-submenu>-->
      <!--<el-menu-item index="2">-->
        <!--<i class="el-icon-menu"></i>-->
        <!--<span slot="title">导航二</span>-->
      <!--</el-menu-item>-->
      <!--<el-menu-item index="3">-->
        <!--<i class="el-icon-document"></i>-->
        <!--<span slot="title">导航三</span>-->
      <!--</el-menu-item>-->
      <el-menu-item index="1">
        <i class="el-icon-setting"></i>
        <span slot="title">首页</span>
      </el-menu-item>
    </el-menu>
  </el-scrollbar>
</template>

<script>
 import {mapGetters}  from 'vuex'

export default {
  props: {
    isCollapse: Boolean,
    default: false
  },
  created () {
    // const accessedRouters = this.routers.filter((route) => {
    //     if (route.children && route.children.length) {
    //       // console.log(route.children)
    //       route.children = route.children
    //       return true
    //     }
    //   return false
    // })
    // console.log(accessedRouters)
    // console.log(this.filterAsyncRouter(this.routers))
  },
  methods: {
    // filterAsyncRouter (asyncRouterMap) {
    //   const accessedRouters = asyncRouterMap.filter(route => {
    //       if (route.children && route.children.length) {
    //         route.children = this.filterAsyncRouter(route.children)
    //         return true
    //       }
    //       return false
    //   })
    //   return accessedRouters
    // }
  },
  computed: {
    ...mapGetters([
      'routers'
    ])
  }
}
</script>

<style lang="stylus" rel="stylesheet/stylus">
  .slider
    .el-scrollbar__wrap
      overflow-x: hidden
      .el-menu
        border: none
        height: 100%
        width: 100%!important
        .el-submenu
          .el-menu-item
            background-color: #1f2d3d!important
            min-width: 180px!important
            &:hover
              background-color: #001528!important
</style>
