<template>
  <div>
    <div class="mx-auto mb-2" style="max-width: 400px">
      <BackButton :route="'user.index'"></BackButton>
    </div>

    <div class="card mx-auto" style="max-width: 400px">
      <div class="card-header bg-secondary text-light text-center">ユーザ登録</div>
      <div class="card-body">
        <form @submit.prevent="regist">
          <BaseText id="name" title="ユーザ名" v-model="name" :errors="errors.name"></BaseText>
          <BaseEmail id="email" title="メールアドレス" v-model="email" :errors="errors.email"></BaseEmail>
          <BasePassword id="password" title="パスワード" v-model="password" :errors="errors.password"></BasePassword>
          <BasePassword id="password_confirmation" title="パスワード（確認用）" v-model="password_confirmation" :errors="errors.password_confirmation"></BasePassword>
          <BaseRadio id="is_admin" title="権限" v-model="is_admin" :errors="errors.is_admin" :items="isAdminItems"></BaseRadio>
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
      errors: [],
      isAdminItems: [
        { value: 1, caption: "管理者"},
        { value: 0, caption: "一般"}
      ],
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