<template>
  <div>
    <div class="overlay"></div>
    <!-- Login card -->
    <div class="login-card col-xs-12 col-sm-8 col-md-6 col-lg-4">
      <i class="fa fa-close close-form text-muted" @click="CloseTheForm()"></i>
      <h3 class="card-title">تسجيل الدخول</h3>
      <div class="card-body">
        <form action="/login" method="post">
          <div class="alert alert-danger" v-if="errorMsg">{{errorMsg}}</div>
          <div class="form-group text-right">
            <label for="email">البريد الإلكتروني:</label>
            <input type="email" class="form-control" id="email" placeholder="بريدك الإلكتروني" v-model="email">
          </div><!-- form group -->

          <div class="form-group text-right">
            <label for="password">كلمة المرور:</label>
            <input type="password" class="form-control" id="password" placeholder="كلمة المرور" v-model="password">
          </div><!-- form group -->

          <div class="checkbox text-right">
            <label>
              <input type="checkbox" class="ml-2" v-model="remember">تذكرني
            </label>
          </div>

          <div class="form-group">
            <input type="submit" value="تسجيل دخول" class="btn btn-primary" :disabled="!isInvalidData || disableButton" @click.prevent="SubmitTheForm()">
          </div><!-- form group -->
          <a href="#">نسيت كلمة السر؟</a>

        </form>
      </div>
    </div><!-- Login card -->
  </div>
</template>
<script>
  export default {
    data: function(){
      return {
        email: '',
        password: '',
        remember: false,
        disableButton: false,
        errorMsg: ''
      };
    },
    computed: {
      isInvalidData: function(){
        return this.EmailIsValid() && this.password;
      }
    },
    methods: {
      CloseTheForm: function(){
        this.$emit('closeform');
      },
      SubmitTheForm: function(){
        this.disableButton = true;
        axios.post(APP_URL + '/login', {
          email: this.email,
          password: this.password,
          remember: this.remember
        }).then(response => {
          if(response.data.status === 'success'){
            location.reload();
          }
        }).catch(error => {
          this.disableButton = false;
          this.errorMsg = error.response.data.message
        });
      },
      EmailIsValid: function(){
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(this.email).toLowerCase());
      }
    }
  }
</script>
