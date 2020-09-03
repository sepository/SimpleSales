<template>
  <div>
    <div class="mx-auto mb-2" style="max-width: 400px">
      <BackButton :route="'user.index'"></BackButton>
    </div>

    <div class="card mx-auto" style="max-width: 400px">
      <div class="card-header bg-secondary text-light text-center">ユーザ登録</div>
      <div class="card-body">
        <form @submit.prevent="regist">
          <div class="form-group">
            <label for="name">ユーザ名</label>
            <input id="name" class="form-control" type="text" v-model="name" :class="{'is-invalid': errors.name}">
            <div class="invalid-feedback" v-for="error in errors.name" v-bind:key="error">
              {{ error }}
            </div>
          </div>

          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" class="form-control" type="email" v-model="email" :class="{'is-invalid': errors.email}">
            <div class="invalid-feedback" v-for="error in errors.email" v-bind:key="error">
              {{ error }}
            </div>
          </div>

          <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" class="form-control" type="password" v-model="password" :class="{'is-invalid': errors.password}">
            <div class="invalid-feedback" v-for="error in errors.password" v-bind:key="error">
              {{ error }}
            </div>
          </div>

          <div class="form-group">
            <label for="password_confirmation">パスワード(確認)</label>
            <input id="password_confirmation" class="form-control" type="password" v-model="password_confirmation" :class="{'is-invalid': errors.password_confirmation}">
            <div class="invalid-feedback" v-for="error in errors.password_confirmation" v-bind:key="error">
              {{ error }}
            </div>
          </div>

          <div class="form-group">
            <label class="w-100" for="is_admin">権限</label>
            <div class="btn-group btn-group-toggle" :class="{'is-invalid': errors.is_admin}">
              <label class="btn btn-outline-secondary" :class="{'active': is_admin == '1'}">
                <input type="radio" name="is_admin" id="is_admin_1" autocomplete="off" value="1" v-model="is_admin">管理者
              </label>
              <label class="btn btn-outline-secondary" :class="{'active': is_admin == '0'}">
                <input type="radio" name="is_admin" id="is_admin_0" autocomplete="off" value="0" v-model="is_admin">一般
              </label>
            </div>
            <div class="invalid-feedback" v-for="error in errors.is_admin" v-bind:key="error">
              {{ error }}
            </div>
          </div>

          <div class="text-center">
            <button class="btn btn-primary" type="submit">登録</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      is_admin: 0,
      errors: []
    }
  },

  methods: {
    regist() {
      axios.post('/api/user/register', {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
        is_admin: this.is_admin
      })
      .then(res => {
        this.$router.push({name: 'user.index'});
      })
      .catch(ex => {
        this.errors = ex.response.data.errors;
      });
    }
  }
}
</script>