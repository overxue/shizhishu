<template>
  <div class="coupon">
    <div class="add">
      <el-button type="primary" icon="el-icon-edit" size="medium" @click="addCoupon">添加</el-button>
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
      <el-table-column label="状态" align="center">
        <template slot-scope="scope">
          <el-tag size="small" type="success" v-if="scope.row.enable">显示</el-tag>
          <el-tag size="small" type="danger" v-else>隐藏</el-tag>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog title="新增优惠券" :visible.sync="dialogFormVisible" :modal-append-to-body='false'>
      <el-form :model="createCoupon" :rules="rules" ref="couponForm">
        <el-form-item label="优惠金额" label-width="110px" prop="money">
          <el-input v-model.number="createCoupon.money" style="width: 350px"></el-input>
        </el-form-item>
        <el-form-item label="最低使用金额" label-width="110px" prop="min_amount">
          <el-input v-model.number="createCoupon.min_amount" style="width: 350px"></el-input>
        </el-form-item>
        <el-form-item label="优惠券总数" label-width="110px" prop="total">
          <el-input v-model.number="createCoupon.total" style="width: 350px"></el-input>
        </el-form-item>
        <el-form-item label="起始时间" label-width="110px" prop="date">
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
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="submitCoupon">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { getCoupon } from 'api/coupon'
import dayjs from 'dayjs'

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
        date: ''
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
      }
    }
  },
  created () {
    this._coupon()
  },
  methods: {
    _coupon () {
      this.loading = true
      getCoupon().then((res) => {
        this.coupons = res.data
        this.loading = false
      })
    },
    addCoupon () {
      this.dialogFormVisible = true
    },
    submitCoupon () {
      console.log(this.createCoupon)
    }
  }
}
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
  .coupon
    padding: 20px
    .add
      margin-bottom: 20px
</style>
