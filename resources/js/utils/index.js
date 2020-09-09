export default {
  methods: {
    /**
     * @param value   値
     * @param format  日付の書式、初期値はYYYY/MM/DD
     * @returns       書式を適用した日付、値が無効ならnull 
     */
    dateFormat(value, format="YYYY/MM/DD")
    {
      if (this.$moment(value).isValid()) {
        return this.$moment(value).format(format);
      }
      else {
        return null;
      }
    },
  }
}