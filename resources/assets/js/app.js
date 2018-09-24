/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}



// Using vue routes
import VueRouter from 'vue-router';
Vue.use(VueRouter);
const router = new VueRouter({
  mode: 'history'
});


// Components
Vue.component('login-form', require('./components/LoginForm.vue'));
Vue.component('register-form', require('./components/RegisterForm.vue'));
Vue.component('add-category', require('./components/AddCategory.vue'));
Vue.component('add-tag', require('./components/AddTag.vue'));
Vue.component('add-author', require('./components/AddAuthor.vue'));
Vue.component('update-userrole', require('./components/UpdateUserRole.vue'));



const app = new Vue({
    el: '#app',
    data: {
      LoginFormIsClicked: false,
      RegisterFormIsClicked: false,
      ShowAddCategory: false,
      ShowAddTag: false,
      ShowAddAuthor: false,
      UpdateUserRole: false,
      ChangeUserIs: 0
    },
    methods: {
      removeBook: function(value, $event){
        axios.delete(APP_URL + '/manage/book/' + value).then(response => {
          if(response.status === 200){
            let trParent = $($event.target).parents('tr');
            if(trParent.siblings().length === 0){
              trParent.remove();
              location.reload();
            }else{
              trParent.remove();
            }
          }
        }).catch(error => {
          console.log(error.response);
        });
      },
      removeCategory: function(value, $event){
        axios.delete(APP_URL + '/manage/category/' + value).then(response => {
          if(response.status === 200){
            let trParent = $($event.target).parents('tr');
            if(trParent.siblings().length === 0){
              trParent.remove();
              location.reload();
            }else{
              trParent.remove();
            }
          }
        }).catch(error => {
          console.log(error.response);
        });
      },
      removeTag: function(value, $event){
        axios.delete(APP_URL + '/manage/tag/' + value).then(response => {
          if(response.status === 200){
            let trParent = $($event.target).parents('tr');
            if(trParent.siblings().length === 0){
              trParent.remove();
              location.reload();
            }else{
              trParent.remove();
            }
          }
        }).catch(error => {
          console.log(error.response);
        })
      },
      removeAuthor: function(value, $event){
        axios.delete(APP_URL + '/manage/author/' + value).then(response => {
          if(response.status === 200){
            let trParent = $($event.target).parents('tr');
            if(trParent.siblings().length === 0){
              trParent.remove();
              location.reload();
            }else{
              trParent.remove();
            }
          }
        }).catch(error => {
          console.log(error.response);
        })
      },
      removeUser: function(value, $event){
        axios.delete(APP_URL + '/manage/user/' + value).then(response => {
          if(response.status === 200){
            $($event.target).parents('tr').remove();
          }
        }).catch(error => {
          console.log(error.response);
        })
      },
      deleteComment: function(value, $event){
        axios.delete(APP_URL + '/comment/' + value).then(response => {
          if(response.status === 200){
            let trParent = $($event.target).parents('tr');
            if(trParent.siblings().length === 0){
              trParent.remove();
              location.reload();
            }else{
              trParent.remove();
            }
          }
        }).catch(error => {
          console.log(error.response);
        })
      },
      removeComment: function(value, $event){
        axios.delete(APP_URL + '/comment/' + value).then(response => {
          if(response.status === 200){
            location.reload();
          }
        }).catch(error => {
          console.log(error.response);
        });
      },
      changeRole: function(value, $event){
        axios.put(APP_URL + '/manage/user/' + value).then(response => {
          // if(response.status === 200){
          //   location.reload();
          // }
          console.log(response.data);
        }).catch(error => {
          console.log(error.response);
        });
      }
    },
    mounted: function(){
      switch(this.$route.hash){
        case '#login':
          this.LoginFormIsClicked = true;
          break;
        case '#register':
          this.RegisterFormIsClicked = true;
          break;
      }
    },
    router
});
