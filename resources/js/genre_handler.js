// 用途: ジャンルの追加・削除を行う
document.addEventListener('DOMContentLoaded', function() {
    // 最大で5つのジャンルを追加できるようにする
    const maxFields = 5;

    // ジャンルの追加ボタンを押したとき
    document.getElementById('add_genre').addEventListener('click', function() {
        // ジャンルの入力欄を追加
        const container = document.getElementById('new_genre_texts');
        if (container.children.length < maxFields) {
            const input = document.createElement('input');
            input.type = "text";
            input.name = "new_genre_texts[]";
            container.appendChild(input);
        }
    });

    // ジャンルの削除ボタンを押したとき
    document.getElementById('remove_genre').addEventListener('click', function() {
        const container = document.getElementById('new_genre_texts');
        if (container.children.length > 1) {
            container.removeChild(container.lastChild);
        }
    });
});
