<template>
  <el-scrollbar style="height: 100%" class="slider">
    <el-menu
      :default-active="$route.path"
      background-color="#304156"
      text-color="#bfcbd9"
      active-text-color="#409EFF"
      :collapse="isCollapse"
    >
      <el-submenu :index="item.path" v-if="item.children && item.children.length" v-for="(item, index) of menu" :key="index">
        <template slot="title">
          <i class="el-icon-location"></i>
          <span slot="title">{{item.title}}</span>
        </template>
        <router-link :to="child.path" v-for="(child, ind) of item.children" :key="ind">
          <el-menu-item :index="child.path">{{child.title}}</el-menu-item>
        </router-link>
      </el-submenu>

      <router-link v-else :to="item.path" tag="li">
        <el-menu-item :index="item.path">
          <i class="el-icon-setting"></i>
          <span slot="title">{{item.title}}</span>
        </el-menu-item>
      </router-link>
    </el-menu>
  </el-scrollbar>
</template>

<script>
 import { mapGetters }  from 'vuex'

export default {
  props: {
    isCollapse: Boolean,
    default: false
  },
  data () {
    return {
      menu: []
    }
  },
  created () {
    // const accessedRouters = this.routers.filter(route => route.children && route.children.length)
    let menu = []
    this.routers.map((route) => {
      if (route.children && route.children.length) {
        route.children.map((item) => {
          if (item.children) {
            let arr = []
            item.children.map((it) => {
              arr.push({ title: it.meta.title, path: it.path })
            })
            menu.push({ title: item.meta.title, icon: item.meta.icon, path: item.path, children: arr })
          } else {
            menu.push({ title: item.meta.title, icon: item.meta.icon, path: item.path })
          }
        })
      }
    })
    this.menu = menu
  },
  methods: {},
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
