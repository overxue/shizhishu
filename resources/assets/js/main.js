import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import Element from 'element-ui'

import 'common/js/permission'

Vue.use(Element)

Vue.config.productionTip = false

const app = new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
});
