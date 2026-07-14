function addBanner() {
    // 追加先
    const bannerList = document.querySelector(".banner-list");
    const addIcon = bannerList.querySelector(".add-icon");
    // 新しい行を作成
    const newBanner = document.createElement("div");
    newBanner.className = "banner-image";

    newBanner.innerHTML = `
        <span class="file-label">選択されていません</span>
        <img class="preview" style="display:none; max-width:200px; max-height:200px;">
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
        if(label){//
            label.style.display = "none";
        }

        if(preview){
            const reader = new FileReader();

            reader.onload = function(e){
                preview.src = e.target.result;
                preview.style.display = "inline-block";
            }

            reader.readAsDataURL(file);
        }

    } else {
        if(label){
            label.style.display = "inline";
        }

        if(preview){
            preview.style.display = "none";
            preview.src = "";
        }
    }
}
    // 登録時チェック（new_images が追加されているのに未選択なら止める）
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('banner-form');
            if (!form) return;

            form.addEventListener('submit', function (e) {
        const inputs = form.querySelectorAll('input[name="new_images[]"]');

            for (let input of inputs) {
              // 行はあるがファイル未選択
                if (!input.files || input.files.length === 0) {
                    alert('ファイルを選択してください');
                    e.preventDefault();
                    return;
                }
            }
        });
    });


// 削除アイコンで行を削除
function removeNewBanner(icon){
    icon.parentElement.remove();
}

//3秒後に成功メッセージを非表示にする
document.addEventListener("DOMContentLoaded", function() {
    const successMessage = document.getElementById("success-message");
    const errorMessage = document.getElementById("error-message");


    if (successMessage) {
        setTimeout(function () {
            successMessage.style.display = "none";
        }, 3000);
    }
    if (errorMessage) {
        setTimeout(function () {
            errorMessage.style.display = "none";
        }, 3000);
    }
});