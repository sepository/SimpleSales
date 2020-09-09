<template>
  <EditForm
    :title="$t('user.register')"
    :link-to-back="{name: 'user.index'}"
    :on-submit="regist"
    :submit-text="$t('common.regist')"
    max-width="400px"
  >
    <BaseText
      id="name"
      v-model="name"
      :title="$t('user.name')"
      :errors="errors.name"
    />
    <BaseEmail
      id="email"
      v-model="email"
      :title="$t('user.email')"
      :errors="errors.email"
    />
    <BasePassword
      id="password"
      v-model="password"
      :title="$t('user.password')"
      :errors="errors.password"
    />
    <BasePassword
      id="password_confirmation"
      v-model="password_confirmation"
      :title="$t('user.password_confirmation')"
      :errors="errors.password_confirmation"
    />
    <BaseRadio
      id="is_admin"
      v-model="is_admin"
      :title="$t('user.authority')"
      :errors="errors.is_admin"
      :items="isAdminItems"
    />
  </EditForm>
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
  },

  computed: {
    isAdminItems() {
      return [
        { value: 1, caption: this.$t('user.authorities.admin') },
        { value: 0, caption: this.$t('user.authorities.ordinary') },
      ];
    },
  },
}
</script>