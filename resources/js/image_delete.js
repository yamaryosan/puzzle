document.addEventListener('DOMContentLoaded', function() {
    // 削除ボタンを取得
    const deleteButtons = document.querySelectorAll('.delete_image_button');
    // 削除ボタンが押されたときの処理
    deleteButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            // 画像を取得(削除ボタンの次の要素)
            const image = button.nextElementSibling;
            // 隠しフォームを取得
            const hiddenForm = image.nextElementSibling;
            // 画像ドロップエリアを取得
            const dropArea = hiddenForm.nextElementSibling;
            // 親要素を取得
            const parent = button.parentElement;
            // 画像を削除
            image.remove();
            // 削除ボタンを削除
            button.remove();
            // 隠しフォームを削除
            hiddenForm.remove();
            // 画像ドロップエリアを削除
            dropArea.remove();
            // 親要素を削除
            parent.remove();
        });
    });
});
