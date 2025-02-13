document.addEventListener('DOMContentLoaded', function () {
    const thumbnailInput = document.getElementById('thumbnail');
    const previewContainer = document.getElementById('thumbnail-preview');

    if (thumbnailInput) {
        // サムネイルの変更イベント
        thumbnailInput.addEventListener('change', function () {
            if (!this.files || !this.files[0]) return;

            const file = this.files[0];

            // 画像ファイルのチェック
            if (!file.type.startsWith('image/')) {
                previewContainer.innerHTML = '<p style="color:red;">選択されたファイルは画像ではありません。</p>';
                return;
            }

            // プレビュー画像を表示
            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" alt="選択された画像">`;
            };
            reader.readAsDataURL(file);
        });
    }
});
