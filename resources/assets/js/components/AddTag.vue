<template>
  <div>
    <div class="overlay"></div>
    <!-- Login card -->
    <div class="adding-card col-xs-12 col-sm-8 col-md-6 col-lg-4">
      <i class="fa fa-close close-form text-muted" @click="CloseTheForm()"></i>
      <h3 class="card-title">
        إضافة تاج جديد
      </h3>
      <div class="card-body">
        <!-- Form is not working yet -->
        <form action="/manage/tags" method="post">

          <div class="form-group text-right">
            <label for="title">العنوان</label>
            <input type="text" class="form-control" id="title" placeholder="العنوان" v-model="title">
            <a class="text text-danger" v-if="error.length > 0">{{error}}</a>
          </div><!-- form group -->

          <div class="form-group">
            <input type="submit" value="إضافة" class="btn btn-primary" :disabled="cantSubmit || disableBtn" @click.prevent="addTag()">
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
        title: '',
        disableBtn: false,
        error: ''
      };
    },
    methods: {
      CloseTheForm: function(){
        this.$emit('closeform');
      },
      addTag: function(){
        this.disableBtn = true;
        axios.post(APP_URL + '/manage/tag', {'title': this.title}).then(response => {
          if(response.status === 201){
            location.reload();
          }
        }).catch(error => {
          if(error.response.status === 422){
            this.error = error.response.data.data.title[0];
            this.disableBtn = false;
          }
        });
      }
    },
    computed: {
      cantSubmit: function(){
        return this.title.trim().length === 0;
      }
    },
    watch: {
      title: function(){
        this.error = '';
      }
    }
  }
</script>
