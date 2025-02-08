document.addEventListener('DOMContentLoaded', function () {
    const deliveryList = document.getElementById('delivery-list');
    const addRowButton = document.getElementById('add-row');

    /** 初期の3行を確保（ただし、削除は最低1行まで許可） */
    function initializeRows() {
        const existingRows = deliveryList.children.length;
        const requiredRows = Math.max(3, existingRows);

        for (let i = existingRows; i < requiredRows; i++) {
            addDeliveryRow();
        }

        updateRemoveButtons(); // 削除ボタンのイベント設定
    }

    /**
     * 配信日時の行を追加
     * @param {string} fromDate - 開始日 (YYYYMMDD)
     * @param {string} fromTime - 開始時間 (HHMM)
     * @param {string} toDate - 終了日 (YYYYMMDD)
     * @param {string} toTime - 終了時間 (HHMM)
     */
    function addDeliveryRow(fromDate = '', fromTime = '', toDate = '', toTime = '') {
        const newRow = document.createElement('div');
        newRow.classList.add('delivery-time-row');

        newRow.innerHTML = `
            <input type="text" name="delivery_from_date[]" value="${fromDate}" placeholder="YYYYMMDD" maxlength="8" required>
            <input type="text" name="delivery_from_time[]" value="${fromTime}" placeholder="HHMM" maxlength="4" required>
            <span class="separator">～</span>
            <input type="text" name="delivery_to_date[]" value="${toDate}" placeholder="YYYYMMDD" maxlength="8" required>
            <input type="text" name="delivery_to_time[]" value="${toTime}" placeholder="HHMM" maxlength="4" required>
            <button type="button" class="btn-remove">−</button>
        `;

        deliveryList.appendChild(newRow);
        updateRemoveButtons(); // 削除ボタンのイベントを更新
    }

    /**
     * 配信日時の行を削除（最低1行を残す）
     * 削除時に対応するエラー文言も削除
     */
    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.btn-remove');

        removeButtons.forEach(button => {
            button.onclick = function () {
                if (deliveryList.children.length > 1) {
                    const row = this.parentElement;

                    // エラー文言の削除（該当行に関連するもののみ）
                    const errorMessages = document.querySelectorAll('.error-message');
                    errorMessages.forEach(error => {
                        if (error.previousElementSibling === row) {
                            error.remove();
                        }
                    });

                    row.remove();
                }

                // 行が0になった場合、新しい行を1つ追加
                if (deliveryList.children.length === 0) {
                    addDeliveryRow();
                }
            };
        });
    }

    /**
     * フォームのバリデーションエラー処理
     * 削除後に不要なエラー文言を削除
     */
    function handleValidationErrors() {
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(error => {
            const previousRow = error.previousElementSibling;
            if (!previousRow || !previousRow.classList.contains('delivery-time-row')) {
                error.remove();
            }
        });
    }

    // イベント: 配信日時の行を追加
    addRowButton.addEventListener('click', function () {
        addDeliveryRow();
    });

    // 初期表示の行をセットアップ
    initializeRows();
});
