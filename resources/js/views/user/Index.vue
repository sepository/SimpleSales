<template>
  <div>
    <div class="d-flex bd-highlight">
      <h1 class="bd-highlight mx-auto">
        {{ $t('user.title') }}
      </h1>
    </div>

    <div class="d-flex bd-highlight">
      <div class="bd-highlight">
        <form class="form-inline" @submit.prevent="search">
          <label class="sr-only" for="keyword">Keyword</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $t('common.filter') }}
              </button>
              <div class="dropdown-menu border-secondary p-3">
                <h6 class="dropdown-header pl-0">
                  {{ $t('user.authority') }}
                </h6>
                <div class="dropdown-item p-0">
                  <BaseRadio
                    id="is-admin"
                    v-model.number="filter.is_admin"
                    :items="isAdminItems"
                    @change-after="search"
                  />
                </div>
                <h6 class="dropdown-header pl-0">
                  {{ $t('user.suspended_user') }}
                </h6>
                <div class="dropdown-item p-0">
                  <BaseRadio
                    id="include-suspended-user"
                    v-model.number="filter.include_suspended_user"
                    :items="includeSuspendedUserItems"
                    @change-after="search"
                  />
                </div>
              </div>
            </div>
            <input id="keyword" v-model="filter.keyword" type="text" class="form-control">
          </div>
        </form>
      </div>

      <div v-if="getAuthUser.is_admin == 1" class="bd-hightlight ml-auto">
        <router-link :to="{name: 'user.register'}">
          <button class="btn btn-primary m-1">
            {{ $t('common.new') }}
          </button>
        </router-link>
      </div>
    </div>

    <div class="card p-0 mt-2">
      <div class="table-responsive">
        <table class="table table-hover m-0">
          <thead>
            <tr class="table-secondary">
              <th scope="col" class="border-0">
                {{ $t('user.name') }}
              </th>
              <th scope="col" class="border-0">
                {{ $t('user.email') }}
              </th>
              <th scope="col" class="border-0">
                {{ $t('user.authority') }}
              </th>
              <th v-if="getAuthUser.is_admin == 1" scope="col" class="border-0"></th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="user in getUsers" v-bind:key="user.id">
              <td class="align-middle">
                {{ user.name }}
              </td>
              <td class="align-middle">
                {{ user.email }}
              </td>
              <td class="align-middle">
                {{ user.is_admin ? $t('user.authorities.admin') : $t('user.authorities.ordinary') }}
              </td>
              <td v-if="getAuthUser.is_admin == 1" class="align-middle text-right">
                <button v-if="user.is_suspended == 0" class="btn btn-danger mx-1" @click="suspend(user)">
                  {{ $t('user.suspend') }}
                </button>
                <button v-else class="btn btn-success mx-1" @click="resume(user)">
                  {{ $t('user.resume') }}
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-flex bd-highlight mt-3">
      <div class="bd-highlight ml-auto">
        <BasePaginate :pageCount="getPageCount" v-bind:currentPage.sync="page.current"/>
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
      if (confirm(this.$t('user.message.confirm_suspend', [user.name]))) {
        axios.put('/api/user/suspend/' + user.id).then(res => {
          this.search();
        });
      }
    },

    resume(user) {
      if (confirm(this.$t('user.message.confirm_resume', [user.name]))) {
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
    },

    isAdminItems() {
      return [
        { value: 2, caption: this.$t('user.authorities.all') },
        { value: 1, caption: this.$t('user.authorities.admin') },
        { value: 0, caption: this.$t('user.authorities.ordinary') },
      ];
    },

    includeSuspendedUserItems() {
      return [
        { value: 1, caption: this.$t('common.include') },
        { value: 0, caption: this.$t('common.exclude') },
      ];
    },
  },

  mounted() {
    axios.get('/api/user/list').then(res => {
      this.search();
    });
  }
}
</script>