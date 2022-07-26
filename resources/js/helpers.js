
export default {
    capFirstLetter(val) {
      return val.charAt(0).toUpperCase() + val.slice(1);
    },
    img2xUrl(val) {
      return `${val.replace(/(\.[\w\d_-]+)$/i, '@2x$1')} 2x`;
    },
    test(price) {
        return price
    }
  };
