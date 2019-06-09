<template>
    <form method="POST" class="calc__form">
        <h1>Hi!!</h1>
    </form>
</template>

<script>
  import Multiselect from 'vue-multiselect'
  // import _ from 'lodash'
  import Datetime from 'vue-datetime'
  import 'vue-datetime/dist/vue-datetime.css'
  import Simplert from 'vue2-simplert'
  import VeeValidate from 'vee-validate'
  // import axios from 'axios'
  // import { TweenLite } from 'gsap'

  let Qs = require('qs')

  require('vue2-simplert/dist/simplert.css')

  Vue.component('multiselect', Multiselect)
  Vue.use(Datetime)
  Vue.use(VeeValidate)

  export default {
    name: 'app',
    components: {
      Multiselect,
      Simplert,
    },
    data () {
      return {}
    },
  }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style lang="scss">
    @import "./css/base/vars";
    @import "./css/base/smart-grid";
    @import "./css/base/misc";
    @import "./css/base/checkbox";
    @import "./css/base/preloader";
    @import "./css/modules/calc";
    @import "./fonts/fonts";
</style>
