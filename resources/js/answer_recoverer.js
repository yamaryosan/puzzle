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
    if (oldAnswers.length === 0) {
        return;
    }

    // 正答コンテナを取得
    const container = document.querySelector('#answer_container');
    // コンテナ内をクリア
    container.innerHTML = '';
    oldAnswers.forEach(function(answer, counter) {

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
        // blockの画像アップロード部分を作成
        const dropArea = createDropArea(counter);
        // ブロックに追加
        newFormBlock.appendChild(textarea);
        newFormBlock.appendChild(dropArea);
        // ブロックに追加
        newFormBlock.appendChild(textarea);
    });
});
