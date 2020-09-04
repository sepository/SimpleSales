<template>
  <div>
    <div class="d-flex bd-highlight">
      <h1 class="bd-highlight mx-auto">ユーザ管理</h1>
    </div>

    <div class="d-flex bd-highlight">
      <div class="bd-highlight">
        <form class="form-inline" @submit.prevent="search">
          <label class="sr-only" for="keyword">Keyword</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">フィルタ</button>
              <div class="dropdown-menu border-secondary p-3">
                <h6 class="dropdown-header pl-0">権限</h6>
                <div class="dropdown-item p-0">
                  <BaseRadio id="is-admin" v-model.number="filter.is_admin" :items="isAdminItems" @change-after="search"></BaseRadio>
                </div>
                <h6 class="dropdown-header pl-0">利用停止中のユーザ</h6>
                <div class="dropdown-item p-0">
                  <BaseRadio id="include-suspended-user" v-model.number="filter.include_suspended_user" :items="includeSuspendedUserItems" @change-after="search"></BaseRadio>
                </div>
              </div>
            </div>
            <input class="form-control" id="keyword" type="text" v-model="filter.keyword">
          </div>
        </form>
      </div>

      <div class="bd-hightlight ml-auto" v-if="getAuthUser.is_admin == 1">
        <router-link :to="{name: 'user.register'}">
          <button class="btn btn-primary m-1">新規</button>
        </router-link>
      </div>
    </div>

    <div class="card p-0 mt-2">
      <div class="table-responsive">
        <table class="table table-hover m-0">
          <thead>
            <tr class="table-secondary">
              <td scope="col" class="border-0">ユーザ名</td>
              <td scope="col" class="border-0">メールアドレス</td>
              <td scope="col" class="border-0">権限</td>
              <td scope="col" class="border-0" v-if="getAuthUser.is_admin == 1"></td>
            </tr>
          </thead>

          <tbody>
            <tr v-for="user in getUsers" v-bind:key="user.id">
              <td class="align-middle">{{ user.name }}</td>
              <td class="align-middle">{{ user.email }}</td>
              <td class="align-middle">{{ user.is_admin ? "管理者" : "一般" }}</td>
              <td class="align-middle text-right" v-if="getAuthUser.is_admin == 1">
                <button class="btn btn-danger mx-1" v-if="user.is_suspended == 0" @click="suspend(user)">利用停止</button>
                <button class="btn btn-success mx-1" v-else @click="resume(user)">利用再開</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-flex bd-highlight mt-3">
      <div class="bd-highlight ml-auto">
        <BasePaginate :pageCount="getPageCount" v-bind:currentPage.sync="page.current"></BasePaginate>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
      filter: {
        keyword: "",
        is_admin: 2,
        include_suspended_user: 0
      },
      page: {
        per: 10,
        current: 1
      },
      isAdminItems: [
        { value: 2, caption: "全て" },
        { value: 1, caption: "管理者" },
        { value: 0, caption: "一般" },
      ],
      includeSuspendedUserItems: [
        { value: 1, caption: "含める" },
        { value: 0, caption: "含めない" },
      ]
    }
  },

  methods: {
    search() {
      axios.get('/api/user/search', {
        params: {
          keyword: this.filter.keyword,
          is_admin: this.filter.is_admin,
          include_suspended_user: this.filter.include_suspended_user
        }
      })
      .then(res => {
        this.users = res.data;
      });
    },

    suspend(user) {
      if (confirm(user.name + "さんの利用を停止します。")) {
        axios.put('/api/user/suspend/' + user.id).then(res => {
          this.search();
        });
      }
    },

    resume(user) {
      if (confirm(user.name + "さんの利用を再開します。")) {
        axios.put('/api/user/resume/' + user.id).then(res => {
          this.search();
        });
      }
    },

    clickPaginate(pageNum) {
      this.currentPage = Number(pageNum);
    }
  },

  computed: {
    getUsers() {
      let current = this.page.current * this.page.per;
      let start = current - this.page.per;
      return this.users.slice(start, current);
    },

    getPageCount() {
      return Math.ceil(this.users.length / this.page.per);
    },

    getAuthUser() {
      return this.$store.getters['auth/user'];
    }
  },

  mounted() {
    axios.get('/api/user/list').then(res => {
      this.search();
    });
  }
}
</script>