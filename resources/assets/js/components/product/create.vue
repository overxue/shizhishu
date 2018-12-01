<template>
  <el-scrollbar style="height: 100%" class="productCreate">
    <div class="create-item">
      <el-row :gutter="20">
        <el-col :span="12" :offset="6">
          <el-form ref="productForm" :model="product" label-width="80px" :rules="rules" style="min-width: 300px; max-width: 550px">
            <el-form-item label="商品名称" prop="title">
              <el-input v-model="product.title" placeholder="请输入商品名称"></el-input>
            </el-form-item>
            <el-form-item label="封面图片" prop="image">
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
            <el-form-item label="单价" prop="price">
              <el-input v-model.number="product.price" placeholder="请输入商品单价"></el-input>
            </el-form-item>
            <el-form-item label="商品分类" prop="category_id">
              <el-select v-model="product.category_id" placeholder="请选择商品分类" style="width: 100%">
                <el-option :label="item.name" :value="item.id" v-for="(item, index) of category" :key="index"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="商品单位" prop="unit">
              <el-select v-model="product.unit" placeholder="请选择商品单位" style="width: 100%">
                <el-option :label="item" :value="item" v-for="(item, index) of unit" :key="index"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="上架">
              <el-radio-group v-model="product.on_sale">
                <el-radio :label="true">是</el-radio>
                <el-radio :label="false">否</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="详情页" prop="detailUrl">
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
              <el-input v-model="product.detailUrl[0]" type="hidden" style="display: none"></el-input>
            </el-form-item>
            <el-form-item style="margin-top: 40px">
              <el-button type="primary" @click="createProduct" :loading="load">提交</el-button>
              <el-button @click="reset">重置</el-button>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
    </div>
  </el-scrollbar>
</template>

<script>
import { createProduct } from 'api/product'
import { getCategory } from 'api/category'

export default {
    data () {
      var checkNumber = (rule, value, callback) => {
        if (!Number.isInteger(value)) {
          callback(new Error('必须是非零正整数'))
        } else {
          if (value <= 0) {
            callback(new Error('必须是非零正整数'))
          } else {
            callback();
          }
        }
      }
      return {
        product: {
          title: '',
          image: '',
          unit: '',
          price: '',
          on_sale: false,
          detailUrl: [],
          category_id: ''
        },
        imageUrl: '',
        unit: ['斤', '件', '瓶', '箱', '袋', '盒', '罐'],
        detailUrl: [],
        fileList: [],
        rules: {
          title: [ { required: true, message: '商品标题不为空', trigger: 'change' } ],
          image: [ { required: true, message: '请上传图片', trigger: 'change' } ],
          price: [ { required: true, message: '必须是非零正整数', trigger: 'change' }, { validator: checkNumber, trigger: 'change' }],
          unit:  [ { required: true, message: '请选择商品单位', trigger: 'change' } ],
          detailUrl: [ { type: 'array', required: true, message: '请上传图片', trigger: 'change' } ],
          category_id: [ { required: true, message: '请选择商品分类', trigger: 'change' } ],
        },
        category: {},
        load: false
      }
    },
    created () {
      this._getCategory()
    },
    methods: {
      _getCategory () {
        getCategory().then((res) => {
          this.category = res.data
        })
      },
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
        this.$refs['productForm'].validate((valid) => {
          if (!valid) return
          this.load = true
          createProduct(this.product).then(() => {
            this.$message.success('新增成功')
            this.reset()
            this.load = false
          })
        })
      },
      reset () {
        this.$refs['productForm'].resetFields()
        this.imageUrl = ''
        this.fileList = []
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
