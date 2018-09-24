<template>
  <div>
    <div class="overlay"></div>
    <!-- Register card -->
    <div class="register-card col-xs-12 col-sm-8 col-md-6 col-lg-4">
      <i class="fa fa-close close-form text-muted" @click="CloseTheForm()"></i>
      <h3 class="card-title">
        إنشاء حساب جديد
      </h3>
      <div class="card-body">
        <form action="/register" method="post">
          <div class="alert alert-danger" v-if="errors.errorMsg">{{errors.errorMsg}}</div>
          <div class="form-group text-right">
            <label for="name">الإسم:</label>
            <input type="text" class="form-control" id="name" placeholder="إسمك" v-model="name">
            <a class="text text-danger"></a>
          </div><!-- form group -->

          <div class="form-group text-right">
            <label for="email">البريد الإلكتروني:</label>
            <input type="email" class="form-control" id="email" placeholder="بريدك الإلكتروني" v-model="email">
          </div><!-- form group -->

          <div class="form-group text-right">
            <label for="password">كلمة المرور:</label>
            <input type="password" class="form-control" id="password" placeholder="كلمة المرور" v-model="password">
          </div><!-- form group -->

          <div class="form-group text-right">
            <label for="password_confirmation">تأكيد كلمة المرور:</label>
            <input type="password" class="form-control" id="password_confirmation" placeholder="تأكيد كلمة المرور" v-model="password_confirmation">
          </div><!-- form group -->

          <div class="form-group">
            <input type="submit" value="إنشاء الحساب" class="btn btn-primary" :disabled="!isInvalidData" @click.prevent="SubmitTheForm()">
          </div><!-- form group -->

        </form>
      </div>
    </div><!-- Register card -->
  </div>
</template>
<script>
  export default {
    data: function(){
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        errors: {
          errorMsg: '',
        }
      };
    },
    computed: {
      isInvalidData: function(){
        return true;
      }
    },
    methods: {
      SubmitTheForm: function(){
        axios.post(APP_URL + '/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        }, {
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        }).then(response => {
          if(response.status === 200){
            location.reload();
          }
        }).catch(error => {
          let responseData = error.response.data;
        });
      },
      CloseTheForm: function(){
        this.$emit('closeform');
      },
      EmailIsValid: function(){
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(this.email).toLowerCase());
      }
    }
  }
</script>
