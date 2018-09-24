<template>
  <div>
    <div class="overlay"></div>
    <!-- Login card -->
    <div class="adding-card col-xs-12 col-sm-8 col-md-6 col-lg-4">
      <i class="fa fa-close close-form text-muted" @click="CloseTheForm()"></i>
      <h3 class="card-title">
        ترقية مستخدم
      </h3>
      <div class="card-body">
        <!-- Form is not working yet -->
        <form action="/manage/user/" method="post">

          <div class="form-group text-right">
            <label for="role">المسئولية</label>
            <select name="role" id="role" class="form-control">
              <option v-for="role in Roles" :value="role.id" :selected="role.id == user[1]">{{role.display_name}}</option>
            </select>
            <a class="text text-danger">{{error}}</a>
          </div><!-- form group -->

          <div class="form-group">
            <input type="submit" value="حفظ" class="btn btn-primary" :disabled="disableBtn" @click.prevent="saveUser()">
          </div><!-- form group -->

        </form>
      </div>
    </div><!-- Login card -->
  </div>
</template>
<script>
  export default {
    props: ['roles', 'user'],
    mounted: function(){
      this.Roles = JSON.parse(this.roles);
    },
    data: function(){
      return {
        disableBtn: false,
        error: '',
        Roles: [],
        newRole: 0
      };
    },
    methods: {
      CloseTheForm: function(){
        this.$emit('closeform');
      },
      saveUser: function(){
        this.disableBtn = true;
        axios.put(APP_URL + '/manage/user/' + this.user[0], {'role': $("#role").val()}).then(response => {
          if(response.status === 200){
            location.reload();
          }
        }).catch(error => {
          this.error = error.response.data.errors.role[0];
          this.disableBtn = false;
        });
      }
    },
    computed: {
      cantSubmit: function(){
        return this.title.trim().length === 0;
      }
    }
  }
</script>
