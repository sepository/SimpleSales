<template>
  <div>
    <nav class="navbar navbar-primary bg-primary">
      <span class="navbar-brand text-light">
        <i class="far fa-credit-card pr-2"></i>Simple Sales
      </span>
      <div class="dropdown" v-if="isLoggedIn()">
        <button class="btn btn-secondary dropdown-toggle text-light" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span style="font-size: 16px">
          <i class="fas fa-user-circle"></i> {{ user.name }}
          </span>
        </button>
        <div class="dropdown-menu dropdown-menu-right bg-secondary" aria-labelledby="dropdownMenu">
          <button class="dropdown-item" type="button" @click="logout">ログアウト</button>
        </div>
      </div>
    </nav>

    <div class="container-fluid p-0">
      <!-- Side Menu Collapse Button -->
      <button class="btn btn-secondary side-btn" @click="isMenuExpanded = !isMenuExpanded" v-if="isAuthenticated">
        <span v-if="isMenuExpanded === true">
          <i class="fas fa-angle-double-left"></i>
        </span>
        <span v-else>
          <i class="fas fa-angle-double-right"></i>
        </span>
      </button>

      <div class="row w-100">
        <!-- Side Menu -->
        <nav class="side col-md-3 col-lg-2 bg-secondary p-5" v-if="isMenuExpanded && isAuthenticated">
          <button class="btn btn-primary text-left w-100 pl-4 mb-2" type="button" data-toggle="collapse" data-target="#collapseWork" aria-expanded="true" aria-controls="collapseWork">
            <span>業務</span>
          </button>
          <ul class="navbar-nav collapse show" id="collapseWork">
            <li class="nav-item">
              <router-link to="/">
              準備中...
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/">
              準備中...
              </router-link>
            </li>
          </ul>

          <button class="btn btn-primary text-left w-100 pl-4 mb-2" type="button" data-toggle="collapse" data-target="#collapseMaster" aria-expanded="true" aria-controls="collapseMaster">
            <span>マスタデータ</span>
          </button>
          <ul class="navbar-nav collapse show" id="collapseMaster">
            <li class="nav-item">
              <router-link to="/customer">
                <i class="fas fa-building content-icon"></i><span class="content-link">取引先</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/">
                <i class="fas fa-book content-icon"></i><span class="content-link">商品</span>
              </router-link>
            </li>
          </ul>
        </nav>

        <!-- Main Contents -->
        <div class="main text-center mt-3" v-bind:class="contentClass">
          <router-view/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: "",
      isMenuExpanded: true,
      isAuthenticated: false
    }
  },
  mounted() {
    if (this.isLoggedIn()) {
      this.getUser();
      this.isAuthenticated = true;
    }
  },
  updated() {
    if (this.isLoggedIn()) {
      if (this.user == "") {
        this.getUser();
      }
      this.isAuthenticated = true;
    } else {
      this.isAuthenticated = false;
    }
  },
  computed: {
    contentClass: function() {
      return {
        'col-md-9': this.isMenuExpanded && this.isAuthenticated,
        'col-lg-10': this.isMenuExpanded && this.isAuthenticated,
        'col-12': !this.isMenuExpanded || !this.isAuthenticated
      }
    }
  },
  methods: {
    isLoggedIn() {
      return localStorage.getItem("auth");
    },
    getUser() {
      axios.get('/api/user').then(response => {
        this.user = response.data;
      })
      .catch(ex => {
        console.log(ex.response);
      })
      ;
    },
    logout() {
      axios.post('/api/logout').then(response => {
        console.log(response);
        localStorage.removeItem('auth');
        this.user = "";
        this.$router.push('/login');
      })
      .catch(error => {
        console.log(error);
      })
    }
  }
}
</script>

<style scoped>
  a {
    color: #fff;
  }
  .navbar {
    height: 60px;
  }
  .navbar-brand {
    font-family: 'Roboto Mono', monospace;
    font-weight: bold;
    font-size: 20px;
  }
  .navbar-nav {
    margin-bottom: 20px;
  }
  .nav-item {
    margin: 5px 0px 5px 30px;
  }
  .content-icon {
    font-size: 16px;
  }
  .content-link {
    margin-left: 10px;
    font-size: 14px;
  }
  .side-btn {
    position: absolute;
    z-index: 1;
  }
  .side {
    height: calc(100vh - 60px);
  }
</style>