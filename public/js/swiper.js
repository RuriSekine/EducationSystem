// DOMの読み込みが完了したら実行
document.addEventListener('DOMContentLoaded', function() {
    // Swiperインスタンスを初期化
    const swiper = new Swiper('.swiper', {
        // 無限ループを有効化
        loop: true,
        // ページネーション（ドット）の設定
        pagination: {
            // ページネーションの要素を指定
            el: '.swiper-pagination',
        },
        // ナビゲーション（前後の矢印）の設定
        navigation: {
            // 「次へ」ボタンの要素を指定
            nextEl: '.swiper-button-next',
            // 「前へ」ボタンの要素を指定
            prevEl: '.swiper-button-prev',
        },
        // 一度に表示するスライド数
        slidesPerView: 1,
        // スライド間のスペース（ピクセル単位）
        spaceBetween: 30,
        // レスポンシブ設定
        breakpoints: {
            // 画面幅が640px以上の場合
            640: {
                slidesPerView: 1,
            },
            // 画面幅が768px以上の場合
            768: {
                slidesPerView: 1,
            },
            // 画面幅が1024px以上の場合
            1024: {
                slidesPerView: 1,
            },
        },
    });
});
