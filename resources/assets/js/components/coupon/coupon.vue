<template>
  <el-scrollbar style="height: 100%" class="coupon">
    <div class="coupon-item">
      <div class="add">
        <el-button type="primary" icon="el-icon-circle-plus-outline" size="medium" @click="addCoupon">添加</el-button>
      </div>
      <el-table :data="coupons" v-loading="loading" stripe style="width: 100%">
        <el-table-column prop="id" label="序号" width="80" sortable align="center"></el-table-column>
        <el-table-column prop="money" label="优惠金额" width="80" align="center"></el-table-column>
        <el-table-column prop="description" label="规则" width="150"></el-table-column>
        <el-table-column prop="total" label="优惠券总数" width="100" align="center"></el-table-column>
        <el-table-column prop="used" label="已领取数量" width="100" align="center"></el-table-column>
        <el-table-column prop="start_time" label="开始时间" width="100" align="center"></el-table-column>
        <el-table-column prop="expirAt" label="过期时间" width="100" align="center"></el-table-column>
        <el-table-column prop="created_at" label="创建时间" width="150" align="center"></el-table-column>
        <el-table-column label="状态" width="80" align="center">
          <template slot-scope="scope">
            <el-tag size="medium" type="success" v-if="scope.row.enable && scope.row.expirAt >= nowTime">显示</el-tag>
            <el-tag size="medium" type="warning" v-else-if="scope.row.expirAt <= nowTime">已过期</el-tag>
            <el-tag size="medium" type="danger" v-else>隐藏</el-tag>
          </template>
        </el-table-column>
        <el-table-column label="操作" min-width="200">
          <template slot-scope="scope">
            <el-button type="primary" icon="el-icon-edit" @click="editCoupon(scope.row)" size="small">修改</el-button>
            <el-button type="danger" icon="el-icon-delete" @click="delCoupon(scope.row)" size="small">删除</el-button>
          </template>
        </el-table-column>
      </el-table>

      <div class="paginate-content" style="width: 100%; padding: 3px; margin-top: 50px">
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

      <el-dialog :title="`${dialogStatus}优惠券`" :visible.sync="dialogFormVisible" :modal-append-to-body='false'>
        <el-form :model="createCoupon" :rules="rules" ref="couponForm" label-width="110px">
          <el-form-item label="优惠金额" prop="money">
            <el-input v-model.number="createCoupon.money" style="width: 350px"></el-input>
          </el-form-item>
          <el-form-item label="最低使用金额" prop="min_amount">
            <el-input v-model.number="createCoupon.min_amount" style="width: 350px"></el-input>
          </el-form-item>
          <el-form-item label="优惠券总数" prop="total">
            <el-input v-model.number="createCoupon.total" style="width: 350px"></el-input>
          </el-form-item>
          <el-form-item label="起始时间" prop="date">
            <el-date-picker
              v-model="createCoupon.date"
              value-format="yyyy-MM-dd"
              type="daterange"
              range-separator="至"
              :picker-options="pickerOptions1"
              start-placeholder="开始日期"
              end-placeholder="结束日期">
            </el-date-picker>
          </el-form-item>
          <el-form-item label="是否显示" label-width="110px">
            <el-switch v-model="createCoupon.enable" active-color="#13ce66" inactive-color="#ff4949"></el-switch>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisible = false">取 消</el-button>
          <el-button v-if="dialogStatus === '新建'" type="primary" @click="submitCoupon" :loading="buttonLoading">确 定</el-button>
          <el-button v-else type="primary" @click="updateCoupon" :loading="buttonLoading">确 定</el-button>
        </div>
      </el-dialog>
    </div>
  </el-scrollbar>
</template>

<script>
import dayjs from 'dayjs'
import { getCoupon, createCoupon, updateCoupon, delCoupon } from 'api/coupon'

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
    var checkMoney = (rule, value, callback) => {
      if (value >= this.createCoupon.min_amount && this.createCoupon.min_amount !== '') {
        callback(new Error('优惠金额必须小于最低使用金额'))
      } else {
        callback()
      }
    }
    var checkMinAmount = (rule, value, callback) => {
      if (value <= this.createCoupon.money) {
        callback(new Error('最低使用金额必须大于优惠金额'))
      } else {
        callback()
      }
    }
    return {
      coupons: [],
      loading: false,
      dialogFormVisible: false,
      createCoupon: {
        money: '',
        min_amount: '',
        total: '',
        date: '',
        enable: true
      },
      pickerOptions1: {
        disabledDate (time) {
          return time.getTime() <= dayjs().subtract(1, 'day')
        }
      },
      rules: {
        money: [
          { required: true, message: '必须是非零正整数', trigger: 'change' },
          { validator: checkNumber, trigger: 'change' },
          { validator: checkMoney, trigger: 'change' }
        ],
        min_amount: [
          { required: true, message: '必须是非零正整数', trigger: 'change' },
          { validator: checkNumber, trigger: 'change' },
          { validator: checkMinAmount, trigger: 'change' }
        ],
        total: [
          { required: true, message: '必须是非零正整数', trigger: 'change' },
          { validator: checkNumber, trigger: 'change' },
        ],
        date: [
          { type: 'array', required: true, message: '请选择日期', trigger: 'change' }
        ]
      },
      buttonLoading: false,
      total: 0,
      // 每页显示的数量
      currentSize: 10,
      // 第几页
      currentPage: 1,
      dialogStatus: '',
      nowTime: dayjs().format('YYYY-MM-DD')
    }
  },
  created () {
    this._coupon()
  },
  methods: {
    _coupon () {
      this.loading = true
      getCoupon(this.currentPage, this.currentSize).then((res) => {
        this.coupons = res.data
        this.total = res.meta.pagination.total
        this.loading = false
      })
    },
    resetCoupon() {
      this.createCoupon = {
        money: '',
        min_amount: '',
        total: '',
        date: '',
        enable: true
      }
    },
    addCoupon () {
      this.resetCoupon()
      this.dialogStatus = '新建'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['couponForm'].clearValidate()
      })
    },
    submitCoupon () {
      this.$refs['couponForm'].validate((valid) => {
        if (!valid) return
        this.buttonLoading = true
        this.createCoupon.not_before = this.createCoupon.date[0]
        this.createCoupon.not_after = this.createCoupon.date[1]
        createCoupon(this.createCoupon).then(() => {
          this.buttonLoading = false
          this.dialogFormVisible = false
          this.$message.success('创建成功')
          this._coupon()
        })
      })
    },
    handleSizeChange (val) {
      this.currentSize = val
      this._coupon()
    },
    handleCurrentChange (val) {
      this.currentPage = val
      this._coupon()
    },
    editCoupon (row) {
      this.dialogStatus = '修改'
      this.dialogFormVisible = true
      this.createCoupon = Object.assign({}, row)
      this.createCoupon.date = [row.start_time, row.expirAt]
      this.$nextTick(() => {
        this.$refs['couponForm'].clearValidate()
      })

      return
      this.createCoupon = row
      this.createCoupon.date = [row.start_time, row.expirAt]
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['couponForm'].clearValidate()
      })
    },
    updateCoupon () {
      this.$refs['couponForm'].validate((valid) => {
        if (!valid) return
        this.buttonLoading = true
        this.createCoupon.not_before = this.createCoupon.date[0]
        this.createCoupon.not_after = this.createCoupon.date[1]
        updateCoupon(this.createCoupon).then(() => {
          this.buttonLoading = false
          this.dialogFormVisible = false
          this.$message.success('修改成功')
          this._coupon()
        })
      })
    },
    delCoupon (row) {
      this.$confirm('此操作将永久删除该优惠券, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        delCoupon(row.id).then(() => {
          this._coupon()
        })
      }).catch(() => {})
    }
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .coupon
    .coupon-item
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
  .coupon
    .el-scrollbar__wrap
      overflow-x: hidden
</style>
