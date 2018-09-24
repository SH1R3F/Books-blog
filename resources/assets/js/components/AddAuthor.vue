<template>
  <div>
    <div class="overlay"></div>
    <!-- Login card -->
    <div class="adding-card col-xs-12 col-sm-8 col-md-6 col-lg-4">
      <i class="fa fa-close close-form text-muted" @click="CloseTheForm()"></i>
      <h3 class="card-title">
        اضافة كاتب جديد
      </h3>
      <div class="card-body">
        <!-- Form is not working yet -->
        <form action="/manage/authors" method="post">

          <div class="form-group text-right">
            <label for="title">الاسم</label>
            <input type="text" class="form-control" id="title" placeholder="الاسم" v-model="name">
            <a class="text text-danger" v-if="error.length > 0">{{error}}</a>
          </div><!-- form group -->

          <div class="form-group">
            <input type="submit" value="إضافة" class="btn btn-primary" :disabled="cantSubmit || disableBtn" @click.prevent="addAuthor()">
          </div><!-- form group -->

        </form>
      </div>
    </div><!-- Login card -->
  </div>
</template>
<script>
  export default {
    data: function(){
      return {
        name: '',
        disableBtn: false,
        error: ''
      };
    },
    methods: {
      CloseTheForm: function(){
        this.$emit('closeform');
      },
      addAuthor: function(){
        this.disableBtn = true;
        axios.post(APP_URL + '/manage/author', {'name': this.name}).then(response => {
          if(response.status === 201){
            location.reload();
          }
        }).catch(error => {
          if(error.response.status === 422){
            let response = error.response.data;
            this.error = response.data.name[0];
            this.disableBtn = false;
          }
        });
      }
    },
    computed: {
      cantSubmit: function(){
        return this.name.trim().length === 0;
      }
    },
    watch: {
      name: function(){
        this.error = ''
      }
    }
  }
</script>
