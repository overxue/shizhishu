<template>
  <div class="login">
    <div class="login-container">
      <h1 class="title">食之蔬</h1>
      <el-form :model="loginForm" :rules="loginRules" ref="loginForm">

        <el-form-item prop="username">
          <span class="icon">
            <i class="iconfont">&#xe614;</i>
          </span>
          <el-input v-model="loginForm.username" type="text" placeholder="请输入账号"></el-input>
        </el-form-item>

        <el-form-item prop="password">
          <span class="icon">
            <i class="iconfont">&#xe916;</i>
          </span>
          <el-input v-model="loginForm.password" :type="passwordType" placeholder="请输入密码" @keyup.enter.native="submitLogin"></el-input>
          <span class="icon-hidden" @click="showPwd">
            <i class="iconfont">&#xe623;</i>
          </span>
        </el-form-item>

        <el-button type="primary" :loading="loading" style="width: 100%" @click="submitLogin">登录</el-button>

      </el-form>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      loginForm: {
        username: '',
        password: ''
      },
      loginRules: {
        username: [
          {required: true, message: '请输入账号', trigger: 'blur'}
        ],
        password: [
          {required: true, message: '请输入密码', trigger: 'blur'}
        ]
      },
      passwordType: 'password',
      loading: false
    }
  },
  methods: {
    showPwd () {
      if (this.passwordType === 'password') {
        this.passwordType = ''
      } else {
        this.passwordType = 'password'
      }
    },
    submitLogin () {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.loading = true
        } else {
          console.log('error submit!!')
          return false
        }
      })
    }
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  @import "~common/stylus/variable"
  .login
    position: fixed
    width: 100%
    height: 100%
    background: $color-background
    .login-container
      position: absolute
      top: 40%
      left: 50%
      transform: translate(-50%,-50%)
      width: 450px
      .title
        font-size: 26px
        color: #eee
        margin-bottom: 40px
        text-align: center
        font-weight: bold
      .icon
        display: inline-block
        padding: 0 0 0 15px
        color: #889aa4
      .icon-hidden
        display: inline-block
        padding-right: 10px
        cursor: pointer;
        color: #889aa4
</style>

<style lang="stylus" rel="stylesheet/stylus">
  /* reset element-ui css */
  @import "~common/stylus/variable"
  .login
    .el-form-item
      border: 1px solid rgba(255, 255, 255, 0.1)
      background: rgba(0, 0, 0, 0.1)
      border-radius: 5px
      color: #454545
      .el-form-item__content
        line-height: 47px
      .el-input
        width: 85%
        height: 47px
        input
          background: transparent
          border: 0px
          -webkit-appearance: none
          border-radius: 0px
          padding: 12px 5px 12px 15px
          color: #eee
          height: 47px
</style>
