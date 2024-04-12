export default function ({ store, isDev }) {

  // 開発モード
  if (isDev) {
    store.commit('setProd', !isDev);
  }
}