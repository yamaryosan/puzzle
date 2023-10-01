// 新しいblockの枠を作成
function createNewBlock() {
    const newFormBlock = document.createElement('div');
    newFormBlock.className = 'answer_block';
    return newFormBlock;
}

// blockのテキストエリアを作成
function createTextarea(counter, removedAnswerTexts) {
    const textarea = document.createElement('textarea');
    textarea.name = `new_answer_text[${counter}]`;
    textarea.required = true;
    textarea.value = removedAnswerTexts.pop() || ''; // 削除されたデータを復元
    return textarea;
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

// 正答入力欄を追加
function addAnswerBlock(removedAnswerTexts, counter) {
    const container = document.getElementById('answer_container');
    const maxFields = 5;

    // blockの枠を作成
    const newFormBlock = createNewBlock();

    // blockのテキストエリアを作成
    counter++;
    const textarea = createTextarea(counter, removedAnswerTexts);

    // blockの画像アップロード部分を作成
    const dropArea = createDropArea(counter);

    // 要素を組み合わせて追加
    if (container.children.length < maxFields) {
        newFormBlock.appendChild(textarea);
        newFormBlock.appendChild(dropArea);
        container.appendChild(newFormBlock);
    };
}

// 残りblockの個数を確認
function countAnswerBlocks(container) {
    const answerBlocks = container.querySelectorAll('.answer_block');
    return answerBlocks.length;
}

// 入力欄の画像ファイルを取得
function getAnswerImages(container) {
    const lastFormBlock = container.lastElementChild;
    const dropArea = lastFormBlock.lastElementChild;
    const fileInput = dropArea.children[1];
    const images = fileInput.files; // 画像ファイルを取得
    return images;
}

// 削除のコア処理
function remove(container, removedAnswerTexts) {
    const lastFormBlock = container.lastElementChild;
    const textarea = lastFormBlock.children[0];
    const textareaValue = textarea.value;
    removedAnswerTexts.push(textareaValue); // 削除されたデータを保存
    container.removeChild(lastFormBlock); // フォームブロックを削除
}

// 正答入力欄を削除
function removeAnswerBlock(removedAnswerTexts) {
    // 入力欄が残り1つの場合は削除しない
    const container = document.getElementById('answer_container');
    if (countAnswerBlocks(container) <= 1) {
        return;
    }
    // 入力欄に画像があるか確認
    const files = getAnswerImages(container);
    // 画像があり、ユーザが削除を確認した場合、あるいは画像がない場合に削除
    if (files.length === 0 || confirm('フォーム欄に画像があります。フォーム欄を削除しますか？')) {
        remove(container, removedAnswerTexts);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // 削除されたデータを保存する配列
    let removedAnswerTexts = [];
    // 入力欄の数を数えるカウンタ
    let answerCount = 0;

    document.getElementById('add_answer').addEventListener('click', function() {
        addAnswerBlock(removedAnswerTexts, answerCount);
        answerCount++;
    });

    document.getElementById('remove_answer').addEventListener('click', function() {
        removeAnswerBlock(removedAnswerTexts);
    });
});
