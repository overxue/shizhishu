<template>
  <div class="productCreate">
    <el-row :gutter="20">
      <el-col :span="12" :offset="6">
        <el-form ref="productForm" :model="product" label-width="80px" style="min-width: 300px; max-width: 550px">
          <el-form-item label="商品名称">
            <el-input v-model="product.title"></el-input>
          </el-form-item>
          <el-form-item label="封面图片">
            <el-upload
              class="avatar-uploader"
              action="https://jsonplaceholder.typicode.com/posts/"
              :show-file-list="false"
              :on-success="handleAvatarSuccess"
              :before-upload="beforeAvatarUpload">
              <img v-if="imageUrl" :src="imageUrl" class="avatar">
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
          </el-form-item>
          <el-form-item label="商品单位">
            <el-select v-model="product.unit" placeholder="请选择活动区域">
              <el-option label="区域一" value="shanghai"></el-option>
              <el-option label="区域二" value="beijing"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="单价">
            <el-input v-model="product.price"></el-input>
          </el-form-item>
          <el-form-item label="上架">
            <el-radio-group v-model="product.on_sale">
              <el-radio label="是"></el-radio>
              <el-radio label="否"></el-radio>
            </el-radio-group>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        product: {},
        imageUrl: ''
      }
    },
    methods: {
      handleAvatarSuccess(res, file) {
        console.log(URL.createObjectURL(file.raw))
        this.imageUrl = URL.createObjectURL(file.raw)
      },
      beforeAvatarUpload(file) {
        const isJPG = file.type === 'image/jpeg'
        const isLt2M = file.size / 1024 / 1024 < 2

        if (!isJPG) {
          this.$message.error('上传头像图片只能是 JPG 格式!')
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!')
        }
        return isJPG && isLt2M;
      }
    }
  }
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .productCreate
    padding: 20px
</style>

<style>
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
</style>
