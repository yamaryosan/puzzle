// 入力し直しのための正答復元

document.addEventListener('DOMContentLoaded', function() {
    if (oldAnswers.length === 0) {
        return;
    }

    // 正答コンテナを取得
    const container = document.querySelector('#answer_container');
    // コンテナ内をクリア
    container.innerHTML = '';
    oldAnswers.forEach(function(answer) {
        // ブロックを作成
        const newFormBlock = document.createElement('div');
        newFormBlock.className = 'answer_block';
        // ブロックをコンテナに追加
        container.appendChild(newFormBlock);
        // テキストエリアを作成
        const textarea = document.createElement('textarea');
        textarea.name = 'new_answer_text[]';
        textarea.placeholder = '正答を入力';
        textarea.required = true;
        textarea.value = answer;
        // ブロックに追加
        newFormBlock.appendChild(textarea);
    });
});
