import Vue from 'vue'

export const defaultState = () => ({
  prod: true,
  step: 0,
  cookieConfirmed: false,
  confirmedId: false,
  inputData: {
    // 医療機関選択
    iryoKikanCode: null,
    // 患者情報
    patient: {
      jyukyusyaNo: null,
      iryoExpY: null,
      iryoExpM: null,
      techoNo: null,
      techoExpY: null,
      techoExpM: null,
      ptNameSei: null,
      ptNameMei: null,
      ptKanaSei: null,
      ptKanaMei: null,
      ptBdayY: null,
      ptBdayM: null,
      ptBdayD: null,
      PtBdaySeireki:null,
      ptAddr: null,
      ptAddrBldg: null,
      ptTel_1st: null,
      ptTel_2nd: null,
      ptTel_3rd: null,
      // 保護者
      under18: false,
      hgNameSei: null,
      hgNameMei: null,
      hgKanaSei: null,
      hgKanaMei: null,
      hgAddr: null,
      hgAddrBldg: null,
      hgTuzukigara: null,
      // 保険情報
      hokenType: null,
      hokenja: null,
      hokenKigo: null,
      hokenBango: null,
      hihoIsMiyazaki: null,
      hihoCity: null,
      hihoNameSei: null,
      hihoNameMei: null,
      hihoKanaSei: null,
      hihoKanaMei: null,
      hihoBdayY: null,
      hihoBdayM: null,
      hihoBdayD: null,
      // 医療機関
      hospital1: null,
      yakkyoku: null,
      houkan: null,
      hospital2: null,
    },
    document: {
      id: null,
    },

    md101: {
      is_nenkin_sikyumoto1: null,
      is_nenkin_sikyumoto2: null,
      is_nenkin_sikyumoto3: null,
      is_nenkin_sikyumoto4: null,
      is_nenkin_sikyumoto5: null,
      is_nenkin_sikyumoto6: null,
      is_techou_face_pic: null,
      nenkin_state: null,
      nenkin_state_kbn_key: null,
      section_key: null,
      sofusakiIryoKikan: null,
      sofusakiKbn: null,
      sstc_douzishinsei_kbn_key: null,
      sstc_saihakkou_kbn_key: null,
      sstc_sinseihouhou_kbn_key: null,
      sstc_sinseinaiyou_kbn_key: null,
    },
    md102: {
      is_sstc_todoke1: null,
      is_sstc_todoke2: null,
      is_sstc_todoke3: null,
      is_sstc_todoke4: null,
      is_saikouhu_shinsei: null,
      is_techou_face_pic: null,
      saikouhu_riyu: null,
      new_address: null,
      new_address_bldg: null,
      new_name: null,
      old_address: null,
      old_address_bldg: null,
      old_name_sei: null,
      old_name_mei: null,
      section_key: null,
      sofusakiIryoKikan: null,
      sofusakiKbn: null,
    },
    md104: {
      sstc_henkanriyu_kbn_key: null,
      sibou_dt: null,
    },
    mj101: {
      ssti_sinseinaiyou_kbn_key: null,
      ssti_sinseihouhou_kbn_key: null,
      is_sindansho_umu: null,
      is_kikan_chosei: null,
      is_jyudo_keizoku_gaito: null,
      is_shogai_nenkin1: null,
      is_shogai_nenkin2: null,
      is_shogai_nenkin3: null,
      is_shogai_nenkin4: null,
      is_shogai_nenkin5: null,
      is_shogai_nenkin6: null,
      is_shogai_nenkin7: null,
      is_nenkin_sikyumoto1: null,
      is_nenkin_sikyumoto2: null,
      is_nenkin_sikyumoto3: null,
      is_nenkin_sikyumoto4: null,
      is_nenkin_sikyumoto5: null,
      is_nenkin_sikyumoto6: null,
      send_postal_code :null,
      send_address: null,
      send_address_building: null,
      send_name: null,
      send_tel: null,
      jyukyuusya_send_kbn_key: null,
      sofusakiKbn: null,
      sofusakiIryoKikan: null,
      kisaiJikoHenko1: null,
      kisaiJikoHenko2: null,
      kisaiJikoHenko3: null,
      kisaiJikoHenko4: null,
      kisaiJikoHenko5: null,
    },
    mj102: {
      ssti_sinseinaiyou_kbn_key: null,
      is_saikouhu_shinsei: null,
      send_postal_code:null,
      send_address: null,
      send_address_building: null,
      send_name: null,
      send_tel: null,
      sofusakiKbn: null,
      sofusakiIryoKikan: null
    },
    mj104: {
      ssti_sinseinaiyou_kbn_key: null,
      d_address :null,
      d_address_building: null,
      d_name_sei: null,
      d_name_mei: null,
      d_kana_name_sei: null,
      d_kana_name_mei: null,
      d_hg_name_sei: null,
      d_hg_name_mei: null,
      d_hg_kana_name_sei: null,
      d_hg_kana_name_mei: null,
      d_hokensha_no: null,
      d_hoken_kigou_no: null,
      jyukyuusha_send_kbn_key: null,
      send_postal_code1: null,
      send_postal_code2: null,
      send_name_sei: null,
      send_name_mei: null,
      send_tel1: null,
      send_tel2: null,
      send_tel3: null,
    },
    mj107: {
      ssti_henkanriyu_kbn_key: null,
      sibou_dt: null,
    },
    sj101: {
      konkaiSinsei: [],
      techoSinseiNiyou: [],
      techoSinseiHohou: null,
      techoDojiSinsei: null,
      iryoSinseiNaiyou: [],
      iryoSinseiHohou: null,
      iryoHenkou: [],
      noDoujiRiyu1: false,
      noDoujiRiyu2: false,
      noDoujiRiyu3: false,
      noDoujiRiyu4: false,
      noDoujiRiyu5: false,
      noDoujiRiyu6: false,
      is_tenpu_doc1: false,
      is_tenpu_doc2: false,
      is_tenpu_doc3: false,
      is_tenpu_doc4: false,
      is_tenpu_doc5: false,
      is_tenpu_doc6: false,
      is_tenpu_doc7: false,
      is_tenpu_doc8: false,
      is_tenpu_doc9: false,
      is_tenpu_doc10: false,
      is_tenpu_doc11: false,
      is_tenpu_doc12: false,
      is_tenpu_doc13: false,
    },
  },
  patients: {},  // 入力履歴保存用
  bookmarks: []
})

export const state = () => defaultState()

const deepCopy = (obj) => {
  return Vue.util.extend({}, obj);
}

const deepCopyAry = (ary) => {
  return Vue.util.extend([], ary);
}

export const getters = {
  getStep: state => {
    return state.step;
  },
  getCookieConfirmed: state => {
    return state.cookieConfirmed;
  },
  getConfirmedId: state => {
    return state.confirmedId;
  },
  isProd: state => {
    return state.prod;
  },
  getIryoKikan: state => {
    return state.inputData.iryoKikanCode;
  },
  getPatient: state => {
    return deepCopy(state.inputData.patient);
  },
  getDocumentId: state => {
    return state.inputData.document.id;
  },
  getMd101: state => {
    return deepCopy(state.inputData.md101);
  },
  getMd102: state => {
    return deepCopy(state.inputData.md102);
  },
  getMd104: state => {
    return deepCopy(state.inputData.md104);
  },
  getMj101: state => {
    return deepCopy(state.inputData.mj101);
  },
  getMj102: state => {
    return deepCopy(state.inputData.mj102);
  },
  getMj104: state => {
    return deepCopy(state.inputData.mj104);
  },
  getMj107: state => {
    return deepCopy(state.inputData.mj107);
  },
  getSj101: state => {
    return deepCopy(state.inputData.sj101);
  },
  getBookmarks: state => {
    return deepCopyAry(state.bookmarks);
  },
}

export const mutations = {
  setPatients(state, obj) {
    state.patients[obj.key] = obj.val;
  },
  setIryoKikan(state, iryoKikanCode) {
    state.inputData.iryoKikanCode = iryoKikanCode;
  },
  setPatient(state, obj) {
    state.inputData.patient = deepCopy(obj);
  },
  setDocumentId(state, id) {
    state.inputData.document.id = id;
  },
  setMd101(state, obj) {
    state.inputData.md101 = deepCopy(obj);
  },
  setMd102(state, obj) {
    state.inputData.md102 = deepCopy(obj);
  },
  setMd104(state, obj) {
    state.inputData.md104 = deepCopy(obj);
  },
  setMj101(state, obj) {
    state.inputData.mj101 = deepCopy(obj);
  },
  setMj102(state, obj) {
    state.inputData.mj102 = deepCopy(obj);
  },
  setMj104(state, obj) {
    state.inputData.mj104 = deepCopy(obj);
  },
  setMj107(state, obj) {
    state.inputData.mj107 = deepCopy(obj);
  },
  setSj101(state, obj) {
    state.inputData.sj101 = deepCopy(obj);
  },
  setStep(state, step) {
    state.step = step;
  },
  setProd(state, bool) {
    state.prod = bool;
  },
  setConfirmedId(state, bool) {
    state.confirmedId = bool;
  },
  setCookieConfirmed(state, confirmed) {
    state.cookieConfirmed = confirmed;
  },
  setBookmarks(state, bookmarks) {
    state.bookmarks = deepCopyAry(bookmarks);
  },
  clearFormData(state) {
    state.inputData.md101 = deepCopy(defaultState().inputData.md101)
    state.inputData.md102 = deepCopy(defaultState().inputData.md102)
    state.inputData.md104 = deepCopy(defaultState().inputData.md104)
    state.inputData.mj101 = deepCopy(defaultState().inputData.mj101)
    state.inputData.mj102 = deepCopy(defaultState().inputData.mj102)
    state.inputData.mj104 = deepCopy(defaultState().inputData.mj104)
    state.inputData.mj107 = deepCopy(defaultState().inputData.mj107)
    state.inputData.sj101 = deepCopy(defaultState().inputData.sj101)
  }
}

export const actions = {
  nuxtClientInit({ commit }, context) {
    const session = JSON.parse(sessionStorage.getItem("meqr")) || null
    const local = JSON.parse(localStorage.getItem("meqr")) || null

    // localStorage
    if (local) {
      commit('setIryoKikan', local.inputData.iryoKikanCode)
      commit('setConfirmedId', local.confirmedId)
      commit('setBookmarks', local.bookmarks)
    }

    // sessionStorage
    if (session) {
      commit('setPatient', session.inputData.patient)
      commit('setDocumentId', session.inputData.document.id)
      commit('setMd101', session.inputData.md101)
      commit('setMd102', session.inputData.md102)
      commit('setMd104', session.inputData.md104)
      commit('setMj101', session.inputData.mj101)
      commit('setMj102', session.inputData.mj102)
      commit('setMj104', session.inputData.mj104)
      commit('setMj107', session.inputData.mj104)
      commit('setSj101', session.inputData.sj101)
      commit('setStep', session.inputData.step)
      commit('setCookieConfirmed', session.cookieConfirmed)
    }
  }
}