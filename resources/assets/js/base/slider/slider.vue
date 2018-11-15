<template>
  <el-scrollbar style="height: 100%" class="slider">
    <el-menu
      :default-active="$route.path"
      background-color="#304156"
      text-color="#bfcbd9"
      active-text-color="#409EFF"
      :collapse="isCollapse"
    >
      <el-submenu :index="item.meta.title" v-if="item.children" v-for="(item, index) of menu" :key="index">
        <template slot="title">
          <i class="el-icon-location"></i>
          <span slot="title">{{item.meta.title}}</span>
        </template>
        <router-link :to="child.path" v-for="(child, ind) of item.children" :key="ind">
          <el-menu-item :index="child.path">{{child.meta.title}}</el-menu-item>
        </router-link>
      </el-submenu>

      <router-link v-else :to="item.path" tag="li">
        <el-menu-item :index="item.path">
          <i class="el-icon-setting"></i>
          <span slot="title">{{item.meta.title}}</span>
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
      onlyOneChild: null,
      menu: []
    }
  },
  created () {
    let menu = []
    this.routers.forEach((res) => {
      const showingChildren = res.children.filter(item => {
        if (item.hidden) {
          return false
        } else {
          return true
        }
      })
      if (showingChildren.length === 1 || res.alwaysShow) {
       menu.push({ meta: showingChildren[0].meta, path: showingChildren[0].path})
      } else {
        menu.push({ meta: res.meta, children: showingChildren })
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
