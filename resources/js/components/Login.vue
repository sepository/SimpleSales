<template>
  <div class="container">
    <form @submit.prevent="login">

      <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>
        <div class="col-md-6">
          <input id="email" class="form-control" type="text" v-model="email">
          <span v-if="errors.email">
            {{ errors.email[0] }}
          </span>
        </div>
      </div>

      <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
        <div class="col-md-6">
          <input id="password" class="form-control" type="password" v-model="password">
          <span v-if="errors.password">
            {{ errors.password[0] }}
          </span>
        </div>
      </div>

      <button class="btn btn-primary">ログイン</button>

    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
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
          console.log(response);
          localStorage.setItem("auth", "true");
          this.$router.push('/');
        })
        .catch(error => {
          this.errors = error.response.data.errors;
        })
      });
    }
  }
}
</script>