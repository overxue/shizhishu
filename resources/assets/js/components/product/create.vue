<template>
  <el-scrollbar style="height: 100%" class="productCreate">
    <div class="create-item">
      <el-row :gutter="20">
        <el-col :span="12" :offset="6">
          <el-form ref="productForm" :model="product" label-width="80px" style="min-width: 300px; max-width: 550px">
            <el-form-item label="商品名称">
              <el-input v-model="product.title" placeholder="请输入商品名称"></el-input>
            </el-form-item>
            <el-form-item label="封面图片">
              <el-upload
                class="avatar-uploader"
                action="/api/images"
                :show-file-list="false"
                name="image"
                :data="{'type': 'product'}"
                :on-success="handleAvatarSuccess"
                :before-upload="beforeAvatarUpload">
                <img v-if="imageUrl" :src="imageUrl" class="avatar">
                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
              </el-upload>
              <el-input v-model="product.image" type="hidden" style="display: none"></el-input>
            </el-form-item>
            <el-form-item label="商品单位">
              <el-select v-model="product.unit" placeholder="请选择商品单位">
                <el-option :label="item" :value="item" v-for="(item, index) of unit" :key="index"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="单价">
              <el-input v-model="product.price" placeholder="请输入商品单价"></el-input>
            </el-form-item>
            <el-form-item label="上架">
              <el-radio-group v-model="product.on_sale">
                <el-radio :label="true">是</el-radio>
                <el-radio :label="false">否</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="详情页">
              <el-upload
                class="upload-demo"
                drag
                action="/api/images"
                name="image"
                :data="{'type': 'productDetail'}"
                :on-success="DetailSuccess"
                :on-remove="handleRemove"
                :file-list="fileList"
                multiple>
                <i class="el-icon-upload"></i>
                <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
              </el-upload>
              <el-carousel height="211px" v-if="fileList.length" style="margin-top: 20px; width: 375px; height: 211px">
                <el-carousel-item v-for="item in fileList" :key="item.name">
                  <img :src="carousel(item)" style="width: 100%; height: 100%">
                </el-carousel-item>
              </el-carousel>
            </el-form-item>
            <el-form-item style="margin-top: 40px">
              <el-button type="primary" @click="createProduct">提交</el-button>
              <el-button>重置</el-button>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
    </div>
  </el-scrollbar>
</template>

<script>
  export default {
    data () {
      return {
        product: {
          title: '',
          image: '',
          unit: '',
          price: '',
          on_sale: false,
          detailUrl: []
        },
        imageUrl: '',
        unit: ['斤', '件', '瓶', '箱', '袋', '盒', '罐'],
        detailUrl: [],
        fileList: []
      }
    },
    methods: {
      handleAvatarSuccess(res, file) {
        this.product.image = res.path
        this.imageUrl = URL.createObjectURL(file.raw)
      },
      DetailSuccess (res, file, fileList) {
        this.product.detailUrl.push(res.path)
        this.detailUrl.push(URL.createObjectURL(file.raw))
        this.fileList = fileList
      },
      carousel (item) {
        return URL.createObjectURL(item.raw)
      },
      handleRemove (file, fileList) {
        this.fileList = fileList
        const url = this.product.detailUrl.filter(item => item !== file.response.path)
        this.product.detailUrl = url
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
      },
      createProduct () {
        console.log(this.product)
      }
    }
  }
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .productCreate
    .create-item
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
    width: 125px;
    height: 125px;
    line-height: 125px;
    text-align: center;
  }
  .avatar {
    width: 125px;
    height: 125px;
    display: block;
  }
</style>

<style lang="stylus" rel="stylesheet/stylus">
  .productCreate
    .el-scrollbar__wrap
      overflow-x: hidden
</style>
