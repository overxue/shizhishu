<template>
  <el-scrollbar style="height: 100%" class="product">
    <div class="product-item">
      <div class="add">
        <el-button type="primary" icon="el-icon-circle-plus-outline" size="medium" @click="addProduct">添加</el-button>
      </div>

      <el-table :data="product" v-loading="loading" stripe style="width: 100%">
        <el-table-column prop="title" label="商品名称" width="100" align="center" show-overflow-tooltip></el-table-column>
        <el-table-column prop="category_id" label="分类" width="80" align="center"></el-table-column>
        <el-table-column prop="price" label="价格" width="80">
          <template slot-scope="scope">
            <span>{{scope.row.price}}/{{scope.row.unit}}</span>
          </template>
        </el-table-column>
        <el-table-column prop="create_at" label="创建时间" width="170" align="center"></el-table-column>
        <el-table-column prop="on_sale" label="状态" width="100" align="center">
          <template slot-scope="scope">
            <el-tag size="medium" type="success" v-if="scope.row.on_sale">上架</el-tag>
            <el-tag size="medium" type="warning" v-else>下架</el-tag>
          </template>
        </el-table-column>
        <el-table-column label="操作" min-width="200">
          <template slot-scope="scope">
            <el-button type="primary" icon="el-icon-edit" @click="editCoupon(scope.row.id)" size="small">修改</el-button>
            <el-button type="danger" icon="el-icon-delete" @click="delProduct(scope.row.id)" size="small">删除</el-button>
          </template>
        </el-table-column>
      </el-table>
      <div class="paginate-content">
        <el-pagination
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
          :current-page="currentPage"
          :page-sizes="[10, 15, 20, 30, 50]"
          :page-size="100"
          layout="total, sizes, prev, pager, next, jumper"
          background
          :total="total">
        </el-pagination>
      </div>
    </div>
  </el-scrollbar>
</template>

<script>
import { product, delProduct } from 'api/product'

export default {
  data () {
    return {
      loading: false,
      product: [],
      total: 0,
      // 每页显示的数量
      currentSize: 10,
      // 第几页
      currentPage: 1,
    }
  },
  created () {
    this._getProduct()
  },
  methods: {
    _getProduct () {
      this.loading = true
      product(this.currentPage, this.currentSize).then((res) => {
        this.product = res.data
        this.total = res.meta.pagination.total
        this.loading = false
      })
    },
    addProduct () {
      this.$router.push({ name: 'CreateProduct'})
    },
    handleSizeChange (val) {
      this.currentSize = val
      this._getProduct()
    },
    handleCurrentChange (val) {
      this.currentPage = val
      this._getProduct()
    },
    delProduct (id) {
      this.$confirm('此操作将永久删除该商品, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        delProduct(id).then(() => {
          this._getProduct()
        })
      }).catch(() => {})
    }
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .product
    .product-item
      padding: 20px
      .add
        margin-bottom: 20px
      .paginate-content
        width: 100%
        padding: 3px
        margin-top: 50px
        overflow: hidden
</style>

<style lang="stylus" rel="stylesheet/stylus">
  .product
    .el-scrollbar__wrap
      overflow-x: hidden
</style>
