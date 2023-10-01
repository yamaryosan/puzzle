function getNextSiblings(element) {
    let nextElements = [];
    if (!element) return nextElements;
    let currentElement = element.nextElementSibling;

    while (currentElement) {
      nextElements.push(currentElement);
      if (currentElement.nextElementSibling === null) break;
      currentElement = currentElement.nextElementSibling;
    }

    return nextElements;
}

document.addEventListener('DOMContentLoaded', function() {
    const hintDeleteButtons = document.querySelectorAll('.delete_hint_button');
    // 削除ボタンが押されたときの処理
    hintDeleteButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            if (window.confirm('ヒントを削除しますか？')) {
                // テキスト入力欄を取得(削除ボタンの前の要素)
                const hintInput = button.previousElementSibling;
                // 削除ボタンの後のすべての要素を取得
                const nextElements = getNextSiblings(button);
                // 親要素を取得
                const parentElement = button.parentElement;
                // テキスト入力欄を削除
                hintInput.remove();
                // 削除ボタンの後のすべての要素を削除
                nextElements.forEach((element) => {
                    element.remove();
                });
                // 削除ボタンを削除
                button.remove();
                // 親要素を削除
                parentElement.remove();
                //
            } else {
                window.alert('キャンセルされました');
            }
        }
    )}
    );
}
);
