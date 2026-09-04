console.log("grade.js 読み込み確認");
document.addEventListener('DOMContentLoaded', function () { //HTMLが全部読み込まれてから処理
    
    const gradeElement = document.getElementById('grade');//HTML取得 箱に
    const gradeName = gradeElement.dataset.gradeName;//中のデータ 箱の中身をとる
    //data-grade-name = dataset.〇〇

    let currentGrade = gradeName;
    // クラスの色分け
    function getGradeClass(name) {
        if (name.includes('小学')) return 'btn btn-primary';
        if (name.includes('中学')) return 'btn btn-info';
        if (name.includes('高校')) return 'btn btn-success';
        return 'btn btn-secondary';
    }

    function updateGrade() {
        // テキスト表示
        gradeElement.textContent = currentGrade;

        // ボタンと同じ見た目にする
        gradeElement.className = 'current-grade ' + getGradeClass(currentGrade);

    }
     // 初期表示
    updateGrade();

    const firstBtn = document.querySelector('[data-grade-id]');//最初のボタンを取得
        if (firstBtn) {
            window.currentGradeId = firstBtn.dataset.gradeId;
            
            loadCurriculums(
            window.currentGradeId,
            window.currentYear,
            window.currentMonth
            );
        }


    //学年ボタンのクリック処理
    document.querySelectorAll('[data-grade-id]').forEach(btn => {
        btn.addEventListener('click', function () {
            // 押したボタンの学年を取得
            console.log('gradeId=', this.dataset.gradeId);
            currentGrade = this.textContent;
            // 表示更新
            updateGrade();
            
            // 現在の学年IDを保存
            window.currentGradeId = this.dataset.gradeId;

            // カリキュラムの読み込み
            loadCurriculums(
                window.currentGradeId,
                window.currentYear,
                window.currentMonth
            );
        });
    });
});