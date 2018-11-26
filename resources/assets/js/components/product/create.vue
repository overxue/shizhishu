<template>
  <div class="productCreate">
    <el-row :gutter="20">
      <el-col :span="12" :offset="6">
        <el-form ref="productForm" :model="product" label-width="80px" style="min-width: 300px; max-width: 550px">
          <el-form-item label="商品名称">
            <el-input v-model="product.title"></el-input>
          </el-form-item>
          <el-form-item label="活动区域">
            <el-select v-model="product.category_id" placeholder="请选择活动区域">
              <el-option label="区域一" value="shanghai"></el-option>
              <el-option label="区域二" value="beijing"></el-option>
            </el-select>
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
        product: {}
      }
    }
  }
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .productCreate
    padding: 20px
</style>
