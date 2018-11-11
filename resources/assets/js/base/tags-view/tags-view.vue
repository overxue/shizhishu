<template>
  <div class="tags-view-container">
    <el-scrollbar style="height: 100%">
      <div class="tags-view-wrapper">
        <span class="tags-view-item active">
        Dashboard
        <span class="el-icon-close"></span>
        </span>
      </div>
    </el-scrollbar>
  </div>
</template>

<script>
export default {}
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
      &.active
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
