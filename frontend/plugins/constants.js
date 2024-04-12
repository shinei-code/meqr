// 西暦和暦スタイル
const getSeirekiWareki = (reverse) => {
  const seirekiWareki = []
  const start = 1868;
  const dt = new Date();
  const end = dt.getFullYear()+2;

  for (let year = start; year <= end; year++) {

    switch (true) {
      case (year == 1868):
        seirekiWareki.push({ val: year, label: year + "年／明治元年" });
        break;
      case (year > 1868 && year < 1912):
        seirekiWareki.push({ val: year, label: year + "年／明治" + (year - 1867) + "年" });
        break;
      case (year == 1912):
        seirekiWareki.push({ val: year, label: year + "年／明治" + (year - 1867) + "年・大正元年" });
        break;
      case (year > 1912 && year < 1926):
        seirekiWareki.push({ val: year, label: year + "年／大正" + (year - 1911) + "年" });
        break;
      case (year == 1926):
        seirekiWareki.push({ val: year, label: year + "年／大正" + (year - 1911) + "年・昭和元年" });
        break;
      case (year > 1926 && year < 1989):
        seirekiWareki.push({ val: year, label: year + "年／昭和" + (year - 1925) + "年" });
        break;
      case (year == 1989):
        seirekiWareki.push({ val: year, label: year + "年／昭和" + (year - 1925) + "年・平成元年" });
        break;
      case (year > 1989 && year < 2019):
        seirekiWareki.push({ val: year, label: year + "年／平成" + (year - 1988) + "年" });
        break;
      case (year == 2019):
        seirekiWareki.push({ val: year, label: year + "年／平成" + (year - 1988) + "年・令和元年" });
        break;
      case (year > 2019):
        seirekiWareki.push({ val: year, label: year + "年／令和" + (year - 2018) + "年" });
        break;
      default:
      // code
    }
  }

  return reverse ? seirekiWareki.sort((current, next) => next.val - current.val) : seirekiWareki;
}

const warekiYearToday = (today) => {
  return getSeirekiWareki().find((y) => y.val == today.getFullYear());
}

export default (context, inject) => {
  // ========== 共通系 ========== //
  inject('SEIREKI_WAREKI', {
    YEAR: getSeirekiWareki(),
    YEAR_REV: getSeirekiWareki(true),  // 降順
    MONTH: [...Array(12)].map((_, i) => ({val: i+1, label: String(i+1)+"月"})),
    DAY: [...Array(31)].map((_, i) => ({val: i+1, label: String(i+1)+"日"})),
  }),

  inject('WAREKI_TODAY', {
    WS_YEAR: warekiYearToday(new Date()).label,
    S_YEAR: warekiYearToday(new Date()).label.split("／")[0],
    W_YEAR: warekiYearToday(new Date()).label.split("／")[1],
    MONTH: ((new Date()).getMonth()+1)+"月",
    DAY: (new Date()).getDate()+"日",
  }),

  inject('COMMON', {
    GENGO: [
      {val: 1, label: '明治'}, 
      {val: 2, label: '大正'}, 
      {val: 3, label: '昭和'}, 
      {val: 4, label: '平成'}, 
      {val: 5, label: '令和'}
    ],
    STEPS: [
      {step: 1, label: "申請者情報"},
      {step: 2, label: "申請書<br>選択"},
      {step: 3, label: "申請内容"},
      {step: 4, label: "申請書"},
    ],
    PW_REG: /^(?=.*?[a-z])(?=.*?\d)(?=.*?[!-\/:-@[-`{-~])[!-~]{8,100}$/i,
    TUZUKIGARA_1: [
      {val: 4, label: "父"},
      {val: 5, label: "母"},
      {val: 6, label: "祖父"},
      {val: 7, label: "祖母"},
      {val: 99, label: "その他"},
    ],
    HOKEN_TYPE: [
      {val: '03', label: "国保（一般）"},
      {val: '01', label: "健保（本人）"},
      {val: '02', label: "健保（家族）"},
      {val: '11', label: "生活保護（受給中）"},
      {val: '12', label: "生活保護（併用保険あり）"},
      {val: '21', label: "後期高齢"},
    ],
    IS_MIYAZAKI: [
      {val: 1, label: "○○市"},
      {val: 0, label: "○○市外"},
    ],
    IRYO_KIKAN_KBN: [
      {val: 1, label: '病院'}, 
      {val: 2, label: '薬局'}, 
      {val: 3, label: '訪問看護'}, 
    ],
    SOFUSAKI_KBN: [
      {val: '1', label: '医療機関へ送付', iryo: 1, techo: 2},
      {val: '2', label: '本人住所へ送付', iryo: 2, techo: 1},
      {val: '99', label: 'その他', iryo: 3, techo: 3},
    ],
    is_techou_face_pic: [ // 手帳の顔写真
      {val: 1, label: "顔写真あり"},
      {val: 0, label: "顔写真無し希望"},
    ],
    section_key: [ // 手帳交付希望窓口
      {val: 1, label: "x1課"},
      {val: 2, label: "x2課"},
      {val: 3, label: "x3課"},
      {val: 4, label: "x4課"},
      {val: 5, label: "x5課"},
    ],
    is_nenkin_sikyumoto: [ // 年金支給元
      {val: 1, label: "日本年金機構"},
      {val: 2, label: "全国市町村職員共済組合連合会"},
      {val: 3, label: "日本私立学校振興、共済事業団"},
      {val: 4, label: "国家公務員共済組合連合"},
      {val: 5, label: "地方公務員共済連合"},
      {val: 6, label: "その他"},
    ],
    HOKEN_QUICK_INPUT: [
      {val: "11111111", label: "xx国保"},
      {val: "22222222", label: "xx社保"},
      {val: "33333333", label: "xx後期高齢"},
    ]

  }),

  inject('Documents', {
    SEISIN_TECHO: [
      { documentId: 'MD101', title: '障がい者手帳申請書', desc: '新規申請(県外転入含む)・更新・等級変更を行う場合に必要な申請書です。' },
      { documentId: 'MD102', title: '記載事項変更届・再交付申請書', desc: '氏名・住所(県外転入含む)に変更があった場合や、紛失等により、手帳を再交付する場合に必要な申請書です。' },
      { documentId: 'MD104', title: '返還届', desc: '手帳を返還するときに必要な申請書です。' },
    ],
    SEISIN_IRYO: [
      { documentId: 'MJ1011', title: '支給認定申請書（新規・再認定）', desc: '新規認定(県外転入含む)・再認定を行う場合に必要な申請書です。' },
      { documentId: 'MJ1012', title: '支給認定申請書（所得区分変更）', desc: '保険に変更があった場合、記載事項変更届出書と併せて作成してください。' },
      { documentId: 'MJ1013', title: '支給認定申請書（医療機関変更）', desc: '医療機関変更を行う場合に必要な申請書です。' },
      { documentId: 'MJ104', title: '記載事項変更届出書 ', desc: '氏名・住所・保護者・保険に変更があった場合に必要な申請書です。' },
      { documentId: 'MJ102', title: '再交付申請書', desc: '紛失等により、受給者証を再交付する場合に必要な申請書です。' },
      { documentId: 'MJ107', title: '返還届', desc: '受給者証を返還するときに必要な申請書です。' },
    ],
    SOFUJO: [
      { documentId: 'SJ101', title: '送付状', desc: '作成した各種申請書と併せて送付してください。' },
    ],
  })

  // ========== 精神手帳関連 ========== //
  inject('MD101', {
    sstc_sinseinaiyou_kbn_key: [  // 申請内容
      {val: 1, label: "新規"},
      {val: 2, label: "更新（有効期限内）"},
      {val: 3, label: "更新（有効期限切れ）"},
      {val: 4, label: "等級変更"},
      {val: 6, label: "xx県外からの転入による手帳申請"},
    ],
    sstc_saihakkou_kbn_key: [  // 手帳再発行
      {val: 1, label: "新手帳発行不要"},
      {val: 2, label: "紛失または作り替え希望により新手帳発行希望"},
    ],
    sstc_douzishinsei_kbn_key: [  // 同時申請
      {val: 1, label: "手帳のみ申請"},
      {val: 2, label: "同時申請"},
      {val: 3, label: "期間調整"},
    ],
    sstc_sinseihouhou_kbn_key: [  // 申請方法
      {val: 1, label: "診断書での申請"},
      {val: 2, label: "年金証書での申請"},
    ],
    nenkin_state_kbn_key: [  // 年金受給状況
      {val: 1, label: "年金を受給している"},
      {val: 2, label: "年金担保貸付制度を利用している"},
    ],
    is_send_to_the_person: [  // 交付決定通知書 送付先
      {val: 1, label: "本人住所"},
      {val: 0, label: "本人住所以外"},
    ],
  })

  inject('MD102', {
    is_sstc_todoke:[
      { val: 1, label: "都道府県における住所変更（xx県内住所変更）" },
      { val: 2, label: "都道府県を越える住所変更" },
      { val: 3, label: "氏名の変更" },
      { val: 4, label: "記載事項変更なし" },
    ],
    is_saikouhu_shinsei: [  // 再交付申請
      {val: 1, label: "再交付申請"},
    ],
    saikouhu_riyu: [  // 再交付理由
      {val: 1, label: "汚れたため"},
      {val: 2, label: "破れたため"},
      {val: 3, label: "紛失したため"},
      {val: 4, label: "その他"},
    ],
  })

  inject('MD104', {
    sstc_henkanriyu_kbn_key: [  // 返還理由
      { val: 1, label: "本人死亡のため" },
      { val: 2, label: "疾患が軽減し手帳所持の必要がなくなったため" },
      { val: 3, label: "再交付申請後に、失くしていた手帳が見つかったため" },
      { val: 99, label: "その他 （申請書に直接記入してください）" },
    ],
  })

  // ========== 精神通院関連 ========== //
  inject('MJ101', {
    ssti_sinseinaiyou_kbn_key: [  // 申請内容
      { val: 1, label: '新規' },
      { val: 2, label: '再認定（有効期限内）'},
      { val: 3, label: '再認定（手帳同時申請）'},
      { val: 4, label: '再認定（有効期限切れ）'},
      { val: 8, label: "xx県外からの転入による申請"},
    ],
    ssti_sinseihouhou_kbn_key: [  // 申請方法
      { val: 1, label: '診断書' },
      { val: 2, label: '手帳用診断書' },
      { val: 3, label: '診断書認定の精神手帳' },
    ],
    is_sindansho_umu: [  // 診断書有無
      { val: 1, label: '診断書あり' },
      { val: 0, label: '診断書なし' },
    ],
    is_kikan_chosei: [  // 期間調整
      { val: 1, label: '期間調整する' },
      { val: 0, label: '期間調整しない' },
    ],
    is_jyudo_keizoku_gaito: [  // 重度かつ継続
      { val: 1, label: '該当' },
      { val: 0, label: '非該当' },
    ],
    is_shogai_nenkin: [  //障がい年金等
      { val: 1, label: '受給なし' },
      { val: 2, label: '障がい年金、または特別障がい給付金' },
      { val: 3, label: '特別児童扶養手当' },
      { val: 4, label: '特別障がい者手当' },
      { val: 5, label: '遺族年金、または寡婦年金' },
      { val: 6, label: '障がいを事由に支給される労働災害による年金' },
      { val: 7, label: 'その他公的年金（老齢年金等の課税年金を除く）' },
    ],
    kisaiJikoHenko: [
      {val: 1, label: "氏名"},
      {val: 2, label: "住所"},
      {val: 3, label: "保険"},
      {val: 4, label: "医療機関"},
    ],
  })
  
  inject('MJ107', {
    ssti_henkanriyu_kbn_key: [  // 返還理由
      { val: 1, label: "受給者死亡のため" },
      { val: 2, label: "精神疾患による通院を行わなくなったため" },
      { val: 3, label: "再交付申請後に、失くしていた受給者証が見つかったため" },
      { val: 99, label: "その他 （申請書に直接記入してください）" },
    ],
  })

  inject('MJ104',{
    is_ssti_todoke: [  // 申請内容
      {val: 1, label: "市内間住所変更"},
      {val: 2, label: "都道府県における住所変更（xx県内市町村からxx市への住所変更）"},
      {val: 3, label: "氏名変更"},
      {val: 4, label: "保護者変更"},
      {val: 5, label: "保険変更"},
    ],
  })

  // ========== 送付状関連 ========== //
  inject('SJ101', {
    KONKAI_SINSEI: [
      { val: 1, label: "精神手帳" },
      { val: 2, label: "自立支援（精神）" },
    ],
    sstc_sinseihouhou_kbn_key: [  // 手帳申請方法
      { val: 1, label: "障がい年金による申請" },
      { val: 2, label: "診断書による申請" },
    ],
    sstc_douzishinsei_kbn_key: [  // 同時申請
      { val: 1, label: "同時申請" },
      { val: 2, label: "期間調整希望" },
      { val: 3, label: "同時申請しない" },
    ],
    is_sstc_sinseinaiyou: [  // 手帳申請
      { val: 1, label: "新規" },
      { val: 2, label: "県外転入" },
      { val: 3, label: "更新（期限切れ含む）" },
      { val: 4, label: "等級変更" },
      { val: 5, label: "記載事項（氏名・住所）変更" },
      { val: 6, label: "再交付" },
      { val: 7, label: "返還" },
    ],
    is_ssti_sinseinaiyou_: [  // 自立支援（精神通院)申請
      { val: 1, label: "新規" },
      { val: 2, label: "県外転入" },
      { val: 3, label: "更新（期限切れ含む）" },
      { val: 4, label: "記載事項（氏名・住所）変更" },
      { val: 5, label: "医療機関単純（病院・薬局のみ）変更" },
      { val: 6, label: "医療機関複数（病院2・訪看あり）変更" },
      { val: 7, label: "再交付" },
      { val: 8, label: "返還" },
    ],
    ssti_sinseihouhou_kbn_key: [  // 自立申請方法
      { val: 1, label: "自立用診断書" },
      { val: 2, label: "手帳用診断書" },
      { val: 3, label: "手帳の写し" },
    ],
    iryohenkounaiyou_key: [  // 医療変更内容
      { val: 1, label: "病院2" },
      { val: 2, label: "訪看関連" },
    ],
    is_tenpu_doc: [  // 添付書類
      { val: 1, label: "年金証書等" },
      { val: 2, label: "振込通知書" },
      { val: 3, label: "手帳用診断書" },
      { val: 4, label: "受給者証原本" },
      { val: 5, label: "保険証・生保受給者証の写し" },
      { val: 6, label: "県外手帳原本" },
      { val: 7, label: "手帳原本" },
      { val: 8, label: "精神通院用診断書" },
      { val: 9, label: "県外受給者証原本" },
      { val: 10, label: "複数医療理由書" },
      { val: 11, label: "訪問看護指示書" },
      { val: 12, label: "顔写真" },
      { val: 13, label: "手帳の写し" },
    ],
    no_douji_riyu: [
      { val: 1, label: "入院中のため、自立支援申請不要" },
      { val: 2, label: "本人希望により、自立支援申請不要" },
      { val: 3, label: "手帳は年金による申請" },
      { val: 4, label: "本人希望により、手帳申請不要" },
      { val: 5, label: "診断後半年未経過のため、手帳申請不可" },
      { val: 6, label: "その他（特記事項欄に理由をご記入ください）" },
    ]
  })
  

}