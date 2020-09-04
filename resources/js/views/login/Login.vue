<template>
  <div class="container">
    <div class="card mx-auto" style="max-width: 400px">
      <div class="card-header bg-secondary text-light text-center">ログイン</div>
      <div class="card-body">
        <form @submit.prevent="login">
          <BaseEmail id="email" title="メールアドレス" v-model="loginForm.email" :errors="errors.email"></BaseEmail>
          <BasePassword id="password" title="パスワード" v-model="loginForm.password" :errors="errors.password"></BasePassword>
          <BaseCheckbox id="should-save" title="次回、メールアドレスの入力を省略する。" v-model.number="shouldSave"></BaseCheckbox>
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
      shouldSave: 0,
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
        localStorage.setItem("shouldSave", this.shouldSave);
      } else {
        localStorage.removeItem("email");
        localStorage.removeItem("shouldSave");
      }

      this.$router.push({name: 'dashboard'});
    }
  },

  mounted() {
    this.loginForm.email = localStorage.getItem("email") ?? "";
    this.shouldSave = Number(localStorage.getItem("shouldSave") ?? 0);
  }
}
</script>