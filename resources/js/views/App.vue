<template>
  <div>
    <nav class="navbar navbar-primary bg-primary">
      <span class="navbar-brand text-light">
        <i class="far fa-credit-card pr-2"></i>Simple Sales
      </span>
      <div v-if="isLoggedIn" class="dropdown ml-auto">
        <button
          id="dropdownMenu"
          type="button"
          class="btn btn-secondary dropdown-toggle text-light"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false">
          <span style="font-size: 16px">
          <i class="fas fa-user-circle"></i> {{ user.name }}
          </span>
        </button>
        <div class="dropdown-menu dropdown-menu-right bg-secondary" aria-labelledby="dropdownMenu">
          <router-link class="dropdown-item" :to="{name: 'profile', params: {userId: user.id}}">
            {{ $t('user.profile') }}
          </router-link>
          <button type="button" class="dropdown-item" @click="logout">
            {{ $t('menu.logout') }}
          </button>
        </div>

      </div>
      <div class="dropdown ml-1">
        <button 
          id="languageMenu" 
          type="button" 
          class="btn btn-secondary dropdown-toggle text-light" 
          data-toggle="dropdown" 
          aria-haspopup="true" 
          aria-expanded="false">
          <span style="font-size: 16px">
          <i class="fas fa-globe"></i> {{ $t('lang.' + $i18n.locale) }}
          </span>
        </button>
        <div class="dropdown-menu dropdown-menu-right bg-secondary" aria-labelledby="languageMenu">
          <button type="button" class="dropdown-item" @click="changeLocale('en')">
            {{ $t('lang.en') }}
          </button>
          <button type="button" class="dropdown-item" @click="changeLocale('ja')">
            {{ $t('lang.ja') }}
          </button>
        </div>
      </div>
    </nav>

    <div class="container-fluid p-0">
      <!-- Side Menu Collapse Button -->
      <button v-if="isLoggedIn" class="btn btn-secondary side-btn" @click="isMenuExpanded = !isMenuExpanded">
        <span v-if="isMenuExpanded === true">
          <i class="fas fa-angle-double-left"></i>
        </span>
        <span v-else>
          <i class="fas fa-angle-double-right"></i>
        </span>
      </button>

      <div class="row w-100 mx-0">
        <!-- Side Menu -->
        <nav v-if="isMenuExpanded && isLoggedIn" class="side col-md-3 col-lg-2 bg-secondary pt-5 px-3">
          <div class="list-group m-0">
            <div v-for="menu in menus" v-bind:key="menu.menuId">
              <button 
                type="button"
                class="list-group-item list-group-item-action list-group-item-primary btn text-left m-0 border-top-0 border-bottom-0 rounded-0" 
                data-toggle="collapse" 
                :data-target="'#' + menu.menuId"
                aria-expanded="true" 
                :aria-controls="menu.menuId">
                <i class="menu-icon fas fa-bars"></i><span class="menu-category">{{ $t('menu.' + menu.menuName) }}</span>
              </button>

              <div class="collapse show" :id="menu.menuId">
                <router-link
                  v-for="item in menu.menuList"
                  v-bind:key="item.name"
                  :to="item.path"
                  class="list-group-item list-group-item-action list-group-item-secondary pl-5">
                  <i class="menu-icon fas" :class="item.icon"></i><span class="menu-text">{{ $t('menu.' + item.name) }}</span>
                </router-link>
              </div>
            </div>
          </div>
        </nav>

        <!-- Main Contents -->
        <div class="main mt-3 px-5" :class="contentClass">
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
      isMenuExpanded: true,
      menus: require('@/settings/menu.json'),
    }
  },

  computed: {
    contentClass: function() {
      return {
        'col-md-9':   this.isMenuExpanded && this.isLoggedIn,
        'col-lg-10':  this.isMenuExpanded && this.isLoggedIn,
        'col-12':     !this.isMenuExpanded || !this.isLoggedIn
      }
    },

    isLoggedIn() {
      return this.$store.getters['auth/check'];
    },

    user() {
      return this.$store.getters['auth/user'];
    },
  },
  
  methods: {
    async logout() {
      await this.$store.dispatch('auth/logout');

      this.$router.push({name: 'login'});
    },

    changeLocale(locale) {
      this.$i18n.locale = locale;
      localStorage.setItem('locale', locale);
    },
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