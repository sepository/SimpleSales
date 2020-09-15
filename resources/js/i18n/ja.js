export default {
  common: {
    new:      "新規",
    edit:     "編集",
    delete:   "削除",
    search:   "検索",
    back:     "戻る",
    regist:   "登録",
    save:     "保存",
    reset:    "取消",
    add:      "追加",
    filter:   "フィルタ",
    include:  "含める",
    exclude:  "含めない",
    undo:     "元に戻す",
    message: {
      confirm_delete: "{0}を削除してもよろしいでしょうか？",
    },
    notify: {
      saved: "保存しました。",
    },
  },

  lang: {
    en: "English",
    ja: "Japanese",
  },

  menu: {
    logout:     "ログアウト",
    works:      "業務",
    masters:    "マスタデータ",
    settings:   "設定",
    customers:  "取引先",
    products:   "商品",
    units:      "単位",
    users:      "ユーザ",
    invoices:   "請求",
  },

  login: {
    title:      "ログイン",
    save_email: "次回、メールアドレスの入力を省略する。",
  },

  customer: {
    title:        "取引先",
    new:          "取引先登録",
    edit:         "取引先編集",
    name:         "名称",
    postal_code:  "郵便番号",
    address:      "住所・宛先",
    tel_no:       "電話番号",
  },

  product: {
    title:    "商品",
    new:      "商品登録",
    edit:     "商品編集",
    name:     "名称",
    price:    "単価",
    unit:     "単位",
    summary:  "概要",
  },

  unit: {
    title:  "単位",
    name:   "名称",
  },

  user: {
    title:                  "ユーザ",
    name:                   "ユーザ名",
    email:                  "メールアドレス", 
    password:               "パスワード",
    password_confirmation:  "パスワード（確認）",
    authority:              "権限",
    authorities: {
      all:                  "全て",
      admin:                "管理者",
      ordinary:             "一般",
    },
    suspended_user:         "利用停止中のユーザ",
    suspend:                "利用停止",
    resume:                 "利用再開",
    profile:                "プロフィール",
    register:               "ユーザ登録",
    message: {
      confirm_suspend:      "{0}さんの利用を停止します。",
      confirm_resume:       "{0}さんの利用を再開します。",
    },
  },

  invoice: {
    title:            "請求",
    new:              "請求書登録",
    edit:             "請求書編集",
    tabs: {
      head:           "請求先",
      detail:         "明細"
    },
    customer:         "取引先",
    invoice_no:       "請求書番号",
    invoice_date:     "請求日",
    payment_due_date: "支払期限",
    remarks:          "備考",
    item: {
      id:             "#",
      product:        "商品",
      price:          "単価",
      quantity:       "数量",
      amount:         "金額",
      remarks:        "備考",
    },
  },
}