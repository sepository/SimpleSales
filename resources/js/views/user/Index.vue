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
                <form class="form-group">
                  <div class="btn-group btn-group-toggle">
                    <label class="btn btn-outline-secondary" :class="{'active': filter.is_admin == ''}">
                      <input type="radio" name="is_admin" id="is_admin1" autocomplete="off" value="" v-model="filter.is_admin" @change="search">全て
                    </label>
                    <label class="btn btn-outline-secondary" :class="{'active': filter.is_admin == '1'}">
                      <input type="radio" name="is_admin" id="is_admin2" autocomplete="off" value="1" v-model="filter.is_admin" @change="search">管理者
                    </label>
                    <label class="btn btn-outline-secondary" :class="{'active': filter.is_admin == '0'}">
                      <input type="radio" name="is_admin" id="is_admin3" autocomplete="off" value="0" v-model="filter.is_admin" @change="search">一般
                    </label>
                  </div>
                </form>
              </div>
            </div>
            <input class="form-control" id="keyword" type="text" v-model="filter.keyword">
          </div>
        </form>
      </div>

      <div class="bd-hightlight ml-auto" v-if="user.is_admin == 1">
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
              <td scope="col" class="border-0"></td>
            </tr>
          </thead>

          <tbody>
            <tr v-for="user in getUsers" v-bind:key="user.id">
              <td class="align-middle">{{ user.name }}</td>
              <td class="align-middle">{{ user.email }}</td>
              <td class="align-middle">{{ user.is_admin ? "管理者" : "一般" }}</td>
              <td class="align-middle text-right">
                <button class="btn btn-primary mx-1">編集</button>
                <button class="btn btn-danger mx-1">削除</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-flex bd-highlight mt-3">
      <div class="bd-highlight ml-auto">
        <Paginate
          :page-count="getPageCount"
          :page-range="3"
          :margin-pages="1"
          :click-handler="clickPaginate"
          :prev-text="'<<'"
          :next-text="'>>'"
          :container-class="'pagination'"
          :page-class="'page-item'"
          :prev-class="'page-item'"
          :next-class="'page-item'"
          :page-link-class="'page-link'"
          :prev-link-class="'page-link'"
          :next-link-class="'page-link'">
        </Paginate>
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
        is_admin: ""
      },
      page: {
        per: 10,
        current: 1
      }
    }
  },

  methods: {
    search() {
      axios.get('/api/user/search', {
        params: {
          keyword: this.filter.keyword,
          is_admin: this.filter.is_admin
        }
      })
      .then(res => {
        this.users = res.data;
      });
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

    user() {
      return this.$store.getters['auth/user'];
    }
  },

  mounted() {
    axios.get('/api/user/list').then(res => {
      this.users = res.data;
    });
  }
}
</script>