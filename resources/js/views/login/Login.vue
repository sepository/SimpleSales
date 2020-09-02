<template>
  <div class="container">
    <div class="card mx-auto" style="max-width: 400px">
      <div class="card-header bg-secondary text-light text-center">ログイン</div>
      <div class="card-body">
        <form @submit.prevent="login">
          <div class="form-group">
            <label for="email" class="form-label">メールアドレス</label>
            <input id="email" class="form-control" type="text" v-model="loginForm.email" :class="{ 'is-invalid': errors.email }">
            <div class="invalid-feedback" v-for="error in errors.email" v-bind:key="error">
              {{ error }}
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="form-label">パスワード</label>
            <input id="password" class="form-control" type="password" v-model="loginForm.password" :class="{ 'is-invalid': errors.password }">
            <div class="invalid-feedback" v-for="error in errors.password" v-bind:key="error">
              {{ error }}
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input id="should-save" class="form-check-input" type="checkbox" v-model="shouldSave">
              <label for="should-save" class="form-check-label">次回、メールアドレスの入力を省略する。</label>
            </div>
          </div>
          <div class="text-center">
            <button class="btn btn-primary">ログイン</button>
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
      loginForm: {
        email: "",
        password: "",
      },
      shouldSave: false,
      errors: []
    }
  },

  methods: {
    async login() {
      await this.$store.dispatch('auth/login', this.loginForm)
        .catch(ex => {
          this.errors = ex.response.data.errors;
          return;
        });

      if (this.shouldSave) {
        localStorage.setItem("email", this.loginForm.email);
        localStorage.setItem("shouldSave", "true");
      } else {
        localStorage.removeItem("email");
        localStorage.removeItem("shouldSave");
      }

      this.$router.push({name: 'dashboard'});
    }
  },

  mounted() {
    this.loginForm.email = localStorage.getItem("email");
    if (localStorage.getItem("shouldSave")) {
      this.shouldSave = true;
    }
  }
}
</script>