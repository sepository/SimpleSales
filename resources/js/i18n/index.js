import Vue from 'vue'
import VueI18n from 'vue-i18n'
import en from './en'
import ja from './ja'

Vue.use(VueI18n)

export function createI18n(locale) {
  axios.post('/api/locale/' + locale)
    .catch(ex => {
      locale = 'en';
    });

  return new VueI18n({
    locale: locale,
    messages: {
      en: en,
      ja: ja,
    }
  });
}
