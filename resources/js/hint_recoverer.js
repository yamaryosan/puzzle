// pタグを作成
function createP(text) {
    const p = document.createElement('p');
    p.textContent = text;
    return p;
}

// blockの画像アップロード部分を作成
function createDropArea(counter) {
    const uniqueId = `file_element_hint_images[${counter}]`;
    const dropArea = document.createElement('div');
    dropArea.className = `drop_area_hint_images[${counter}]`;
    dropArea.innerHTML = `
    <p>ここに画像をドロップ、または</p>
    <input type="file" name="new_hint_images[${counter}][]" id="${uniqueId}" multiple accept="image/*">
    <label class="button" for="${uniqueId}">ファイルを選択</label>
    `;
    return dropArea;
}

// 入力し直しのためのヒント復元

document.addEventListener('DOMContentLoaded', function() {
    const oldHintsArray = Object.values(oldHints);
    console.log(oldHintsArray);

    if (oldHintsArray.length === 0) {
        return;
    }

    // ヒントコンテナを取得
    const container = document.querySelector('#hint_container');
    // コンテナ内をクリア
    container.innerHTML = '';

    // pタグを作成
    const p = createP('ヒント');
    // コンテナに追加
    container.appendChild(p);

    oldHintsArray.forEach(function(hint, counter) {
        // ブロックを作成
        const newFormBlock = document.createElement('div');
        newFormBlock.className = 'hint_block';
        // ブロックをコンテナに追加
        container.appendChild(newFormBlock);
        // テキストエリアを作成
        const textarea = document.createElement('textarea');
        textarea.name = `new_hint_text[${counter + 1}]`;
        textarea.placeholder = '正答を入力';
        textarea.required = true;
        textarea.value = hint;
        // blockの画像アップロード部分を作成
        const dropArea = createDropArea(counter + 1);
        // ブロックに追加
        newFormBlock.appendChild(textarea);
        newFormBlock.appendChild(dropArea);
    });
});
