// 新しいblockの枠を作成
function createNewBlock() {
    const newFormBlock = document.createElement('div');
    newFormBlock.className = 'new_hint_block';
    return newFormBlock;
}

// blockのテキストエリアを作成
function createTextarea(counter, removedHintTexts) {
    const textarea = document.createElement('textarea');
    textarea.name = `new_hint_text[${counter}]`;
    textarea.required = true;
    textarea.value = removedHintTexts.pop() || ''; // 削除されたデータを復元
    textarea.placeholder = 'ヒント本文を入力';
    return textarea;
}

// blockの画像アップロード部分を作成
function createDropArea(counter) {
    const uniqueId = `file_element_hint_images[${counter}]`;
    const dropArea = document.createElement('div');
    dropArea.className = `drop_area_hint_images[${counter}] drop_area`;
    dropArea.innerHTML = `
    <p>ここに画像をドロップ、または</p>
    <input type="file" name="new_hint_images[${counter}][]" id="${uniqueId}" multiple accept="image/*">
    <label class="button" for="${uniqueId}">ファイルを選択</label>
    `;
    return dropArea;
}

// ヒント入力欄を追加
function addHintBlock(removedHintTexts, counter) {
    const container = document.getElementById('hint_container');
    const maxFields = 5;

    // blockの枠を作成
    const newFormBlock = createNewBlock();

    // blockのテキストエリアを作成
    counter++;
    const textarea = createTextarea(counter, removedHintTexts);

    // blockの画像アップロード部分を作成
    const dropArea = createDropArea(counter);

    // 要素を組み合わせて追加
    if (container.children.length < maxFields) {
        newFormBlock.appendChild(textarea);
        newFormBlock.appendChild(dropArea);
        container.appendChild(newFormBlock);
    };
}

// 削除予定のblockの有無を確認
function confirmNewHintBlock(lastElement) {
    if (lastElement.className !== 'new_hint_block') {
        return false;
    }
    return true;
}

// 入力欄の画像ファイルを取得
function getHintImages(container) {
    const lastFormBlock = container.lastElementChild;
    const dropArea = lastFormBlock.lastElementChild;
    const fileInput = dropArea.children[1];
    const images = fileInput.files; // 画像ファイルを取得
    return images;
}

// 削除のコア処理
function remove(container, removedHintTexts) {
    const lastFormBlock = container.lastElementChild;
    const textarea = lastFormBlock.children[0];
    const textareaValue = textarea.value;
    removedHintTexts.push(textareaValue); // 削除されたデータを保存
    container.removeChild(lastFormBlock); // フォームブロックを削除
}

// ヒント入力欄を削除
function removeHintBlock(removedHintTexts) {
    // 削除予定のblockがあるか確認
    const container = document.getElementById('hint_container');
    if (!confirmNewHintBlock(container.lastElementChild)) {
        return;
    }
    // フォーム欄に画像があるか確認
    const files = getHintImages(container);
    // 画像があり、ユーザが削除を確認した場合、あるいは画像がない場合に削除
    if (files.length === 0 || confirm('フォーム欄に画像があります。フォーム欄を削除しますか？')) {
        remove(container, removedHintTexts);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // 削除されたデータを保存する配列
    let removedHintTexts = [];
    // フォーム欄の数を数えるカウンタ
    let hintCount = 0;

    document.getElementById('add_hint').addEventListener('click', function() {
        addHintBlock(removedHintTexts, hintCount);
        hintCount++;
    });

    document.getElementById('remove_hint').addEventListener('click', function() {
        removeHintBlock(removedHintTexts);
    });
});
