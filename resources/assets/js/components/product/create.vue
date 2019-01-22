<template>
  <el-scrollbar style="height: 100%" class="productCreate">
    <div class="create-item">
      <el-row :gutter="20">
        <el-col :span="12" :offset="6">
          <create-form :product="product" @createForm="createProduct" ref="productForm"></create-form>
        </el-col>
      </el-row>
    </div>
  </el-scrollbar>
</template>

<script>
import { getCategory } from 'api/category'
import { createProduct } from 'api/product'
import CreateForm from './form'

export default {
    data () {
      return {
        product: {
          title: '',
          image: '',
          unit: '',
          price: '',
          on_sale: false,
          detailUrl: [],
          category_id: ''
        }
      }
    },
    methods: {
      createProduct (form) {
        createProduct(form).then(() => {
          this.$message.success('新增成功')
          this.$refs.productForm.reset()
        })
      }
    },
    components: {
      CreateForm
    }
  }
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .productCreate
    background: #fff
    .create-item
      padding: 20px
</style>

<style lang="stylus" rel="stylesheet/stylus">
  .productCreate
    .el-scrollbar__wrap
      overflow-x: hidden
</style>
