document.addEventListener('DOMContentLoaded', function () {
    const thumbnailInput = document.getElementById('thumbnail');
    const thumbnailPreviewContainer = document.getElementById('thumbnail-preview');

    // サムネイル画像のプレビュー処理
    thumbnailInput.addEventListener('change', function () {
        if (!this.files || !this.files[0]) return;

        // 既存のプレビューをクリアし、新しい画像要素を用意
        let previewImage = thumbnailPreviewContainer.querySelector('img') || document.createElement('img');
        previewImage.style.maxWidth = '100%';
        previewImage.style.maxHeight = '100%';
        previewImage.style.borderRadius = '5px';

        thumbnailPreviewContainer.innerHTML = ''; 
        thumbnailPreviewContainer.appendChild(previewImage);

        const file = this.files[0];

        // 画像以外のファイルを選択した場合の警告表示
        if (!file.type.startsWith('image/')) {
            thumbnailPreviewContainer.innerHTML = '<p style="color:red;">選択されたファイルは画像ではありません。</p>';
            return;
        }

        // ファイルを読み込んでプレビューに表示
        const reader = new FileReader();
        reader.onload = (e) => previewImage.src = e.target.result;
        reader.readAsDataURL(file);
    });
});
