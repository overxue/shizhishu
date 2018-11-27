<template>
  <div class="tags-view-container">
    <el-scrollbar style="height: 100%">
      <div class="tags-view-wrapper">
        <draggable v-model="visitedList">
          <router-link tag="span" :to="tag.path" class="tags-view-item" v-for="(tag, index) of visitedViews" :key="index">
            {{tag.title}}
            <span class="el-icon-close" @click.prevent.stop='closeSelectedTag(tag.path, index)'></span>
          </router-link>
        </draggable>
      </div>
    </el-scrollbar>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'
import draggable from 'vuedraggable'

export default {
  created () {
    this.addViewTags()
  },
  computed: {
    visitedList: {
      get () {
        return this.visitedViews
      },
      set (value) {
        this.mapMutations(value)
      }
    },
    ...mapGetters([
      'visitedViews'
    ])
  },
  methods: {
    addViewTags () {
      const route = this.generateRoute()
      if (!route) {
        return false
      }
      this.saveVisitedViews(route)
    },
    generateRoute () {
      if (this.$route.name) {
        return this.$route
      }
      return false
    },
    closeSelectedTag (path, index) {
      if (path === '/dashboard' && index === 0 && this.visitedViews.length === 1) {
        return
      }
      this.delVisitedViews(index).then(() => {
        if (path === this.$route.path) {
          const latestView = this.visitedViews.slice(-1)[0]
          if (latestView) {
            this.$router.push(latestView)
          } else {
            this.$router.push('/')
          }
        }
      })
    },
    ...mapActions([
      'saveVisitedViews',
      'delVisitedViews'
    ]),
    ...mapMutations({
      mapMutations: 'SET_VISITED_VIEWS'
    })
  },
  watch: {
    $route () {
      this.addViewTags()
    }
  },
  components: {
    draggable
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .tags-view-container
    background: #fff
    border-bottom: 1px solid #d8dce5
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.12), 0 0 3px 0 rgba(0,0,0,.04)
    height: 35px
    width: 100%
    white-space: nowrap;
    overflow: hidden;
    .tags-view-item
      display: inline-block
      position: relative
      height: 26px
      line-height: 28px
      border: 1px solid #d8dce5
      color: #495060
      background: #fff
      padding: 0 8px
      font-size: 12px
      margin-left: 5px
      margin-top: 3px
      cursor: pointer
      &:first-of-type
        margin-left: 15px
      &:last-of-type
        margin-right: 15px
      &.router-link-active
        background-color: #42b983
        color: #fff
        border-color: #42b983
        &::before
          content: ''
          background: #fff
          display: inline-block
          width: 8px
          height: 8px
          border-radius: 50%
          position: relative
          margin-right: 2px
</style>

<style lang="stylus" rel="stylesheet/stylus">
  .tags-view-container
    .el-scrollbar__wrap
      overflow-x: hidden
      .tags-view-item
        .el-icon-close
          width: 16px
          height: 16px
          vertical-align: 2px
          border-radius: 50%
          text-align: center
          transition: all .3s cubic-bezier(.645, .045, .355, 1)
          transform-origin: 100% 50%
          &:before
            transform: scale(.6)
            display: inline-block
            vertical-align: -2px
          &:hover
            background-color: #b4bccc
            color: #fff
</style>
