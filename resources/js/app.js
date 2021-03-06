/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import App from '@/views/App'
import router from './router'
import store from  './store'
import { createI18n } from './i18n'
import utils from './utils'
import upperFirst from 'lodash/upperFirst'
import camelCase from 'lodash/camelCase'
import Paginate from 'vuejs-paginate'
import DatePicker from 'vuejs-datepicker'
import Toasted from 'vue-toasted'

// commonフォルダから共通コンポーネント取得
const requireComponent = require.context(
    '@/components', false, /[A-Z]\w+\.(vue|js)$/
)

// 共通コンポーネントをグローバル登録
requireComponent.keys().forEach(fileName => {
    const componentConfig = requireComponent(fileName)
    const componentName = upperFirst(
        camelCase(
            fileName
                .split('/')
                .pop()
                .replace(/\.\w+$/, '')
        )
    )
    Vue.component(componentName, componentConfig.default || componentConfig)
})

// コンポーネントのグローバル登録
Vue.component('Paginate', Paginate)
Vue.component('DatePicker', DatePicker)

// ライブラリ読み込み
Vue.use(Toasted)
Vue.use(require('vue-moment'))
Vue.mixin(utils)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const createApp = async() => {
    await store.dispatch('auth/currentUser');

    let locale = localStorage.getItem('locale') ?? 'en';
    const i18n = createI18n(locale);
    
    new Vue({
        el: '#app',
        router,
        store,
        i18n,
        components: { App },
        template: '<App/>'
    });
};

createApp();
