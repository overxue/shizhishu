<template>
  <el-scrollbar wrapClass="scrollbar-wrapper" style="height: 100%">
    <el-menu
      :show-timeout="200"
      :default-active="$route.path"
      :collapse="isCollapse"
      background-color="#304156"
      text-color="#bfcbd9"
      active-text-color="#409EFF"
    >
      <!--单个-->
      <div>
        <router-link to="/">
          <el-menu-item>
            <i class="el-icon-menu"></i>
            <span slot="title">首页</span>
          </el-menu-item>
        </router-link>
      </div>

      <el-submenu>
        <template slot="title">
          <i class="el-icon-location"></i>
          <span slot="title">导航一</span>
        </template>
        <router-link to="login">
          <el-menu-item>
            <span>测试1</span>
          </el-menu-item>
        </router-link>
      </el-submenu>
    </el-menu>
  </el-scrollbar>
</template>

<script>
export default {}
</script>

<style lang="stylus" rel="stylesheet/stylus">
  .scrollbar-wrapper
    overflow-x: hidden
    .el-scrollbar__view
      height: 100%
      .el-menu
        height: 100%
        width: 100%
        .el-submenu
          a
            display: inline-block
            width: 100%
            overflow: hidden
            .el-menu-item
              min-width: 180px !important
              background-color: #1f2d3d !important
              &:hover
                background-color: #001528 !important
</style>
