<template>
  <div class="container">
    <div class="card mx-auto" style="max-width: 400px">
      <div class="card-header bg-secondary text-light text-center">ログイン</div>
      <div class="card-body">
        <form @submit.prevent="login">
          <div class="form-group">
            <label for="email" class="form-label">メールアドレス</label>
            <input id="email" class="form-control" type="text" v-model="email" :class="{ 'is-invalid': errors.email }">
            <div class="invalid-feedback" v-for="error in errors.email" v-bind:key="error">
              {{ error }}
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="form-label">パスワード</label>
            <input id="password" class="form-control" type="password" v-model="password" :class="{ 'is-invalid': errors.password }">
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
      email: "",
      password: "",
      shouldSave: false,
      errors: []
    }
  },

  methods: {
    login() {
      axios.get("/sanctum/csrf-cookie").then(response => {
        axios.post("api/login", {
          email: this.email,
          password: this.password
        })
        .then(response => {
          if (this.shouldSave) {
            localStorage.setItem("email", this.email);
            localStorage.setItem("shouldSave", "true");
          } else {
            localStorage.removeItem("email");
            localStorage.removeItem("shouldSave");
          }
          localStorage.setItem("auth", "true");
          this.$router.push('/');
        })
        .catch(error => {
          this.errors = error.response.data.errors;
        })
      });
    }
  },

  mounted() {
    this.email = localStorage.getItem("email");
    if (localStorage.getItem("shouldSave")) {
      this.shouldSave = true;
    }
  }
}
</script>