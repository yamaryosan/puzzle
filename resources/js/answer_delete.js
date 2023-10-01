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
    const answerDeleteButtons = document.querySelectorAll('.delete_answer_button');
    // 削除ボタンが押されたときの処理
    answerDeleteButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            // 正答の数が1つのときは削除できない
            const answerCount = document.querySelectorAll('.existing_answer_block').length;
            if (answerCount <= 1) {
                return;
            }

            // 確認ダイアログを表示
            if (window.confirm('正答を削除しますか？')) {
                // テキスト入力欄を取得(削除ボタンの前の要素)
                const answerInput = button.previousElementSibling;
                // 削除ボタンの後のすべての要素を取得
                const nextElements = getNextSiblings(button);
                // 親要素を取得
                const parentElement = button.parentElement;
                // テキスト入力欄を削除
                answerInput.remove();
                // 削除ボタンの後のすべての要素を削除
                nextElements.forEach((element) => {
                    element.remove();
                });
                // 削除ボタンを削除
                button.remove();
                // 親要素を削除
                parentElement.remove();
            } else {
            }
        }
    )}
    );
}
);
