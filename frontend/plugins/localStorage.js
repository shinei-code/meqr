import createPersistedState from "vuex-persistedstate";

export default ({store, isHMR}) => {
  if (isHMR) return;

  if (process.client) {
    window.onNuxtReady((nuxt) => {
      createPersistedState(
          {
            key: 'meqr',
            paths: [
              'inputData.iryoKikanCode', 
              'patients', 
              'bookmarks', 
              'confirmedId'
            ],
            storage: window.localStorage,
          },
      )(store); 
      createPersistedState(
        {
          key: 'meqr',
          paths: [
            'inputData.patient',
            'inputData.document',
            'inputData.md101',
            'inputData.md102',
            'inputData.md104',
            'inputData.mj101',
            'inputData.mj102',
            'inputData.mj104',
            'inputData.mj107',
            'inputData.sj101',
            'step',
            'cookieConfirmed',
            'prod'
          ],
          storage: window.sessionStorage,
        }
    )(store); 
    });
  }
};