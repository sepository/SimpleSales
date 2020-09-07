<template>
  <div class="container">
    <div class="card mx-auto" style="max-width: 400px">
      <div class="card-header bg-secondary text-light text-center">
        {{ $t('user.profile') }}
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <tbody>
              <tr>
                <td class="border-top-0">
                  {{ $t('user.name') }}
                </td>
                <td class="border-top-0">
                  {{ user.name }}
                </td>
              </tr>
              <tr>
                <td>
                  {{ $t('user.email') }}
                </td>
                <td>
                  {{ user.email }}
                </td>
              </tr>
              <tr>
                <td>
                  {{ $t('user.authority') }}
                </td>
                <td>
                  {{ user.is_admin ? $t('user.authorities.admin') : $t('user.authorities.ordinary') }}
                </td>
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
      axios.get('/api/user/profile/' + this.userId)
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