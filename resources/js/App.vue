<template>
  <div id="app">
    <nav class="navbar navbar-primary bg-primary">
      <span class="navbar-brand">Simple Sales</span>
    </nav>

    <div class="container-fluid p-0">
      <!-- Side Menu Collapse Button -->
      <button class="btn btn-secondary side-btn" @click="isMenuExpanded = !isMenuExpanded">
        <span v-if="isMenuExpanded === true">
          <i class="fas fa-angle-double-left"></i>
        </span>
        <span v-else>
          <i class="fas fa-angle-double-right"></i>
        </span>
      </button>

      <div class="row w-100">
        <!-- Side Menu -->
        <nav class="side col-md-3 col-lg-2 bg-secondary p-5" v-if="isMenuExpanded">
          <button class="btn btn-primary text-left w-100 pl-4 mb-2" type="button" data-toggle="collapse" data-target="#collapseWork" aria-expanded="true" aria-controls="collapseWork">
            <span>業務</span>
          </button>
          <ul class="navbar-nav collapse show" id="collapseWork">
            <li class="nav-item"><router-link to="/">
              準備中...
            </router-link></li>
            <li class="nav-item"><router-link to="/">
              準備中...
            </router-link></li>
          </ul>

          <button class="btn btn-primary text-left w-100 pl-4 mb-2" type="button" data-toggle="collapse" data-target="#collapseMaster" aria-expanded="true" aria-controls="collapseMaster">
            <span>マスタデータ</span>
          </button>
          <ul class="navbar-nav collapse show" id="collapseMaster">
            <li class="nav-item"><router-link to="/">
              <i class="fas fa-building"></i><span class="content">取引先</span>
            </router-link></li>
            <li class="nav-item"><router-link to="/">
              <i class="fas fa-book"></i><span class="content">商品</span>
              </router-link></li>
          </ul>
        </nav>

        <!-- Main Contents -->
        <div class="main col-md-9 col-lg-10 text-center">
          main
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isMenuExpanded: true
    }
  }
}
</script>

<style scoped>
  a {
    color: #fff;
    font-weight: bold;
    font-size: 16px;
  }
  .navbar {
    height: 60px;
  }
  .navbar-nav {
    margin-bottom: 20px;
  }
  .nav-item {
    margin: 5px 0px 5px 30px;
  }
  .content {
    margin-left: 10px;
  }
  .side-btn {
    position: absolute;
    z-index: 1;
  }
  .side {
    height: calc(100vh - 60px);
  }
</style>