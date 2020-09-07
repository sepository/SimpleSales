<template>
  <div class="container">
    <div class="card mx-auto" style="max-width: 400px">
      <div class="card-header bg-secondary text-light text-center">
        {{ $t('login.title') }}
      </div>
      <div class="card-body">
        <form @submit.prevent="login">
          <BaseEmail id="email" :title="$t('user.email')" v-model="loginForm.email" :errors="errors.email"></BaseEmail>
          <BasePassword id="password" :title="$t('user.password')" v-model="loginForm.password" :errors="errors.password"></BasePassword>
          <BaseCheckbox id="should-save" :title="$t('login.save_email')" v-model.number="shouldSave"></BaseCheckbox>
          <div class="text-center">
            <button class="btn btn-primary">
              {{ $t('login.title') }}
            </button>
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