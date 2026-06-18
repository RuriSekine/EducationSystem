document.addEventListener('DOMContentLoaded', function () { //HTMLが全部読み込まれてから処理
    
    let currentDate = new Date();//今の日時を取得

    function updateMonth() { //更新
        const year = currentDate.getFullYear(); //年取得
        const month = currentDate.getMonth() + 1; //月取得

        //HTMLに表示
        document.getElementById('currentMonth').textContent =
            `${year}年${month}月スケジュール`;
    }

    //初期(ページを開いたときに表示)
    updateMonth();

    // 前月
    document.getElementById('lastMonth').addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        updateMonth();
    });

    // 次月
    document.getElementById('nextMonth').addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        updateMonth();
    });
});