function addBanner() {
    // 追加先
    const bannerList = document.querySelector(".banner-list");
    const addIcon = bannerList.querySelector(".add-icon");
    // 新しい行を作成
    const newBanner = document.createElement("div");
    newBanner.className = "banner-image";

    newBanner.innerHTML = `
        <span class="file-label">選択されていません</span>
        <img class="preview" style="display:none; max-width:200px; max-height:200px; margin-left:10px;">
        <button type="button" class="file-btn">ファイルを選択</button>
        <input type="file" name="new_images[]" style="display:none;" onchange="updateFileLabel(this)">
        <i class="fa-solid fa-circle-minus" style="color: #ff0000;" onclick="removeNewBanner(this)"></i>
    `;
    // 挿入位置＋アイコン上
    bannerList.insertBefore(newBanner, addIcon);
}

// ファイル選択ボタンを押して隠し
document.addEventListener("click", function(e){
    if(e.target.classList.contains("file-btn")){
        e.target.nextElementSibling.click();
    }
});

// ファイル選択後にプレビュー表示
function updateFileLabel(input){
    const label = input.parentElement.querySelector(".file-label");
    const preview = input.parentElement.querySelector(".preview");

    if(input.files && input.files.length > 0){
        const file = input.files[0];
        label.style.display = "none";

        const reader = new FileReader();
        reader.onload = function(e){
            preview.src = e.target.result;
            preview.style.display = "inline-block";
        }
        reader.readAsDataURL(file);
    } else {
        label.style.display = "inline";
        preview.style.display = "none";
        preview.src = "";
    }
}

// 削除アイコンで行を削除
function removeNewBanner(icon){
    icon.parentElement.remove();
}
