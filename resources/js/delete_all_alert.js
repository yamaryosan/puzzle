// 全削除ボタン押下時のアラート
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('delete_all').addEventListener('click', function(event) {
        // ボタンのクリックイベントを無効化
        event.preventDefault();

        // 最初のアラートを表示
        if (window.confirm('全てのデータを削除しますか？')) {
            // 2つ目のアラートを表示
            if (window.confirm('本当に全てのデータを削除しますか？')) {
                document.getElementById('delete_all_form').submit();
            } else {
                window.alert('キャンセルされました');
            }
        }
    });
});
