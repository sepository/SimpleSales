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

      <div class="row w-100 mx-0">
        <!-- Side Menu -->
        <nav class="side col-md-3 col-lg-2 bg-secondary pt-5 px-3" v-if="isMenuExpanded && isAuthenticated">
          <div class="list-group m-0">
            <div v-for="menu in menus" v-bind:key="menu.menuId">
              <button 
                class="list-group-item list-group-item-action list-group-item-primary btn text-left m-0 border-top-0 border-bottom-0 rounded-0" 
                type="button" 
                data-toggle="collapse" 
                :data-target="'#' + menu.menuId"
                aria-expanded="true" 
                :aria-controls="menu.menuId">
                <i class="menu-icon fas fa-bars"></i><span class="menu-category">{{ menu.menuName }}</span>
              </button>

              <div class="collapse show" :id="menu.menuId">
                <router-link
                  class="list-group-item list-group-item-action list-group-item-secondary pl-5"
                  v-for="item in menu.menuList"
                  v-bind:key="item.name" 
                  :to="item.path">
                  <i class="menu-icon fas" :class="item.icon"></i><span class="menu-text">{{ item.name }}</span>
                </router-link>
              </div>
            </div>
          </div>
        </nav>

        <!-- Main Contents -->
        <div class="main mt-3 px-5" v-bind:class="contentClass">
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
      isAuthenticated: false,
      menus: require('@/settings/menu.json'),
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
        this.logout();
      });
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
  .navbar {
    height: 60px;
  }
  .navbar-brand {
    font-family: 'Roboto Mono', monospace;
    font-weight: bold;
    font-size: 20px;
  }
  .side-btn {
    position: absolute;
    z-index: 1;
  }
  .side {
    height: calc(100vh - 60px);
  }
  .menu-category {
    font-size: 16px;
  }
  .menu-icon {
    font-size: 18px;
    margin-right: 10px;
  }
  .menu-text {
    font-size: 16px;
  }
</style>