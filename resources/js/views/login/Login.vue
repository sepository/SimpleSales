<template>
  <div class="container">
    <div class="card mx-auto" style="max-width: 400px">
      <div class="card-header bg-secondary text-light text-center">
        {{ $t('login.title') }}
      </div>
      <div class="card-body">
        <form @submit.prevent="login">
          <BaseEmail
            id="email"
            v-model="loginForm.email"
            :title="$t('user.email')"
            :errors="errors.email"
          />
          <BasePassword
            id="password"
            v-model="loginForm.password"
            :title="$t('user.password')"
            :errors="errors.password"
          />
          <BaseCheckbox
            id="should-save"
            v-model.number="shouldSave"
            :title="$t('login.save_email')"
          />
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