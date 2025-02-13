document.addEventListener('DOMContentLoaded', function () {
    const availableGrades = document.getElementById('available-grades');
    const selectedGradePlaceholder = document.getElementById('selected-grade-placeholder');
    const listSection = document.getElementById('list-section');
    const gradeButtons = Array.from(availableGrades.children); // 元の順番を保持
    let currentlySelectedGrade = null; // 現在選択中の学年を管理

    /**
     * 学年ボタンがクリックされた場合の処理
     */
    availableGrades.addEventListener('click', function (e) {
        if (e.target.classList.contains('filter-btn')) {
            handleGradeButtonClick(e.target);
        }
    });

    /**
     * 移動したボタンをクリックするとフィルタをリセット
     */
    selectedGradePlaceholder.addEventListener('click', function (e) {
        if (e.target.classList.contains('filter-btn')) {
            resetFilter();
        }
    });

    /**
     * 学年ボタンを選択・移動・フィルタリング
     * @param {HTMLElement} gradeBtn - クリックされた学年ボタン
     */
    function handleGradeButtonClick(gradeBtn) {
        const selectedGrade = gradeBtn.getAttribute('data-grade');

        // 既に選択されていた場合、リセット
        if (currentlySelectedGrade === selectedGrade) {
            resetFilter();
            return;
        }

        // 現在の選択を更新
        currentlySelectedGrade = selectedGrade;

        // 既に選択されたボタンがある場合、元の位置に戻す
        if (selectedGradePlaceholder.firstChild) {
            returnButtonToOriginalPosition(selectedGradePlaceholder.firstChild);
        }

        // 選択したボタンを新規登録の横に移動
        selectedGradePlaceholder.appendChild(gradeBtn);

        // 授業リストをフィルタリング
        filterSections(selectedGrade);
    }

    /**
     * 学年ボタンを元の位置に戻す
     * @param {HTMLElement} button - 移動した学年ボタン
     */
    function returnButtonToOriginalPosition(button) {
        const gradeName = button.getAttribute('data-grade');
        const originalIndex = gradeButtons.findIndex(btn => btn.getAttribute('data-grade') === gradeName);

        // 元の順番で挿入
        if (originalIndex !== -1) {
            availableGrades.insertBefore(button, availableGrades.children[originalIndex]);
        } else {
            availableGrades.appendChild(button);
        }
    }

    /**
     * 授業リストをフィルタリング
     * @param {string} selectedGrade - 選択された学年
     */
    function filterSections(selectedGrade) {
        const gradeSections = document.querySelectorAll('.grade-section');
        gradeSections.forEach(section => {
            section.style.display = section.getAttribute('data-grade') === selectedGrade ? '' : 'none';
        });
    }

    /**
     * フィルターをリセットし、全ての授業を表示
     */
    function resetFilter() {
        currentlySelectedGrade = null;

        if (selectedGradePlaceholder.firstChild) {
            returnButtonToOriginalPosition(selectedGradePlaceholder.firstChild);
        }

        const gradeSections = document.querySelectorAll('.grade-section');
        gradeSections.forEach(section => {
            section.style.display = ''; // 全て表示
        });
    }
});
