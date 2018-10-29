<template>
  <div class="login">
    <div class="login-container">
      <h1 class="title">
        <img width="120" height="120" src="./login.png" class="avatar-item">
      </h1>
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
            <i class="iconfont" v-html="icon"></i>
          </span>
        </el-form-item>

        <el-button type="primary" :disabled="showLogin" :loading="loading" @click="submitLogin">登录</el-button>

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
      loading: false,
      icon: '&#xe70f;'
    }
  },
  computed: {
    showLogin () {
      if (this.loginForm.username && this.loginForm.password) {
        return false
      }
      return true
    }
  },
  methods: {
    showPwd () {
      if (this.passwordType === 'password') {
        this.icon = '&#xe623;'
        this.passwordType = ''
      } else {
        this.icon = '&#xe70f;'
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
  .login
    position: fixed
    width: 100%
    height: 100%
    background-image: url("./background.jpg")
    .login-container
      position: absolute
      top: 50%
      left: 50%
      transform: translate(-50%,-50%)
      background: #fff
      min-width: 450px
      box-shadow: 0 0 25px #cac6c6
      padding: 30px
      .title
        margin-bottom: 20px
        text-align: center
      .icon
        display: inline-block
        padding: 0 0 0 15px
        color: #889aa4
      .icon-hidden
        display: inline-block
        padding-right: 10px
        cursor: pointer
        color: #889aa4
</style>

<style lang="stylus" rel="stylesheet/stylus">
  /* reset element-ui css */
  .login
    .el-form-item
      border: 1px solid #dcdfe6
      border-radius: 5px
      .el-form-item__content
        line-height: 47px
      .el-input
        width: 85%
        height: 47px
        input
          border: 0px
          border-radius: 0px
          padding: 12px 5px 12px 15px
          height: 47px
    .el-button
      margin-top: 10px
      width: 100%
</style>
