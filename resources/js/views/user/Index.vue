<template>
  <TheIndex
    ref="index"
    :title="$t('user.title')"
    :filter-enabled="true"
    :link-to-new="getAuthUser.is_admin == 1 ? {name: 'user.register'} : ''"
    :on-submit="onSubmit"
  >
    <template v-slot:filters>
      <TheIndexFilterItem>
        <BaseRadio
          id="is-admin"
          v-model.number="filter.is_admin"
          :title="$t('user.authority')"
          :items="isAdminItems"
        />
      </TheIndexFilterItem>

      <TheIndexFilterItem>
        <BaseRadio
          id="include-suspended-user"
          v-model.number="filter.include_suspended_user"
          :title="$t('user.suspended_user')"
          :items="includeSuspendedUserItems"
        />
      </TheIndexFilterItem>
    </template>

    <TheIndexSearchResult :columns="columns">
      <tr v-for="user in getPageUsers" v-bind:key="user.id">
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
    </TheIndexSearchResult>

    <template v-slot:paginate>
      <BasePaginate :pageCount="getPageCount" v-bind:currentPage.sync="paginate.current"/>
    </template>
  </TheIndex>
</template>

<script>
export default {
  data() {
    return {
      filter: {
        is_admin: 2,
        include_suspended_user: 0
      },
      paginate: {
        per: 10,
        current: 1
      },

      users: [],
    }
  },

  methods: {
    search() {
      this.$refs.index.submit();
    },

    onSubmit(keyword = "") {
      axios.get('/api/user/search', {
        params: {
          keyword: keyword,
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
      this.paginate.current = Number(pageNum);
    }
  },

  computed: {
    columns() {
      let columns = [
        this.$t('user.name'),
        this.$t('user.email'),
        this.$t('user.authority'),
      ];

      if (this.getAuthUser.is_admin == 1) {
        columns.push("");
      }

      return columns;
    },

    getPageUsers() {
      let current = this.paginate.current * this.paginate.per;
      let start = current - this.paginate.per;
      return this.users.slice(start, current);
    },

    getPageCount() {
      return Math.ceil(this.users.length / this.paginate.per);
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