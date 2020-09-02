<template>
  <div class="container">
    <div class="card mx-auto" style="max-width: 400px">
      <div class="card-header bg-secondary text-light text-center">プロフィール</div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <tbody>
              <tr>
                <td class="border-top-0">ユーザ名</td>
                <td class="border-top-0">{{ user.name }}</td>
              </tr>
              <tr>
                <td>メールアドレス</td>
                <td>{{ user.email }}</td>
              </tr>
              <tr>
                <td>権限</td>
                <td>{{ user.is_admin ? "管理者" : "一般" }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    userId: Number
  },

  data() {
    return {
      user: ""
    }
  },

  methods: {
    getUser() {
      axios.get('/api/user/' + this.userId)
        .then(res => {
          this.user = res.data;
        });
    }
  },

  mounted() {
    this.getUser();
  }
}
</script>