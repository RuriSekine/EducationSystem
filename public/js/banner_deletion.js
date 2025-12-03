function markBannerDeletion(bannerId) {
    console.log(bannerId);

    //既存divを非表示
    const deleteBanner = document.getElementById("banner-id" + bannerId);
    if (deleteBanner) {
        deleteBanner.style.display = "none";

        // 非表示にしたものを格納
        let form = document.getElementById('banner-form'); //格納先→例：郵便局
        let input = document.createElement('input'); //削除対象が入る袋→例：手紙
        input.type = 'hidden'; //画面上に表示しない
        input.name = 'delete_ids[]'; //リスト→例：手紙に書かれた宛先
        input.value = bannerId; //削除してほしいバナーid→例：内容
        form.appendChild(input);  //削除対象の袋を格納
    }
}

function removeNewBanner(icon) {

    //新規divを非表示※DB追加前
    const deleteNewBanner = icon.parentElement;
    deleteNewBanner.style.display ="none";
}