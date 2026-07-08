console.log("curriculum.js 読み込み確認");

// 開始日時用（7月14日 13:45）
function formatDateTime(dateTime) {
    const date = new Date(dateTime);

    const month = date.getMonth() + 1;
    const day = date.getDate();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${month}月${day}日 ${hours}:${minutes}`;
}

// 終了時刻用（17:45）
function formatTime(dateTime) {
    const date = new Date(dateTime);

    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${hours}:${minutes}`;
}

window.loadCurriculums = function (gradeId) {
    //loadCurriculums という名前の処理を作って、windowでブラウザ全体使えるようにする

    const curriculumList = document.getElementById('curriculum-list');
    //カリキュラム一覧を表示する要素を取得

    fetch(`/user/api/curriculums?grade_id=${gradeId}`)
    //fetchで/api/curriculumsにアクセスして、gradeIdを送る(リクエスト)
    .then(response => response.json())
    //レスポンスをjson形式に変換する
    .then(data => {
        console.log(data,"カリキュラム取得");

        curriculumList.innerHTML = '';//カリキュラム一覧を空にする

        data.forEach(curriculum => {
            console.log(curriculum.title);
            // カードを作成
            const card = document.createElement('div');//divタグを作成
            card.className = 'curriculum-card';
            
                //画像表示(サムネイル）
                const thumbnail = document.createElement('img');
                thumbnail.className = 'curriculum-thumbnail';
                thumbnail.src = '/' + curriculum.thumbnail;
                card.appendChild(thumbnail);
                
                //タイトル表示
                const title = document.createElement('h5');
                title.className = 'curriculum-title';
                title.textContent = curriculum.title;
                card.appendChild(title);
                
                if (curriculum.alway_delivery_flg === 0) {
                    curriculum.delivery_times.forEach(deliveryTime => {
                         //配信期間
                        const deliveryTimeElement = document.createElement('p');
                        deliveryTimeElement.className = 'curriculum-delivery-time';
                        deliveryTimeElement.textContent = `配信期間: ${formatDateTime(deliveryTime.delivery_from)} ～ ${formatTime(deliveryTime.delivery_to)}`;
                        card.appendChild(deliveryTimeElement);
                    });
                } else {
                    //配信期間
                    const deliveryTimeElement = document.createElement('p');
                    deliveryTimeElement.className = 'curriculum-delivery-time';
                    deliveryTimeElement.textContent = `常時公開`;
                    card.appendChild(deliveryTimeElement);
                }

            // 一覧へ追加
            curriculumList.appendChild(card);
        });
    });
}