// pタグを作成
function createP(text) {
    const p = document.createElement('p');
    p.textContent = text;
    return p;
}

// blockの画像アップロード部分を作成
function createDropArea(counter) {
    const uniqueId = `file_element_answer_images[${counter}]`;
    const dropArea = document.createElement('div');
    dropArea.className = `drop_area_answer_images[${counter}]`;
    dropArea.innerHTML = `
    <p>ここに画像をドロップ、または</p>
    <input type="file" name="new_answer_images[${counter}][]" id="${uniqueId}" multiple accept="image/*">
    <label class="button" for="${uniqueId}">ファイルを選択</label>
    `;
    return dropArea;
}

// 入力し直しのための正答復元

document.addEventListener('DOMContentLoaded', function() {
    // 連想配列を配列に変換
    const oldAnswersArray = Object.values(oldAnswers);
    if (oldAnswersArray.length === 0) {
        return;
    }

    // 正答コンテナを取得
    const container = document.querySelector('#answer_container');
    // コンテナ内をクリア
    container.innerHTML = '';

    // pタグを作成
    const p = createP('正答');
    // コンテナに追加
    container.appendChild(p);

    oldAnswersArray.forEach(function(answer, counter) {
        // ブロックを作成
        const newFormBlock = document.createElement('div');
        newFormBlock.className = 'answer_block';
        // ブロックをコンテナに追加
        container.appendChild(newFormBlock);
        // テキストエリアを作成
        const textarea = document.createElement('textarea');
        textarea.name = `new_answer_text[${counter + 1}]`;
        textarea.placeholder = '正答を入力';
        textarea.required = true;
        textarea.value = answer;
        // blockの画像アップロード部分を作成
        const dropArea = createDropArea(counter + 1);
        // ブロックに追加
        newFormBlock.appendChild(textarea);
        newFormBlock.appendChild(dropArea);
    });
});
