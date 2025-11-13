function markBannerDeletion(bannerId) {
    console.log(bannerId);

    //既存divを非表示
    const deleteBanner = document.getElementById("banner-id" + bannerId);
    if (deleteBanner) {
        deleteBanner.style.display = "none";
    }
}

function removeNewBanner(icon) {

    //新規divを非表示※DB追加前
    const deleteNewBanner = icon.parentElement;
    deleteNewBanner.style.display ="none";
}