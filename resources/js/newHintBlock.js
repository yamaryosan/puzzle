/**
 * ヒント入力欄ブロックを表すオブジェクト
 * @param {number} counter - ヒント入力欄の数
 * @param {array} removedTexts - 削除されたテキスト
 * @param {array} oldHints - 入力し直しのためのヒント
 */
class HintBlock {
    /**
     *
     * @param {number} counter
     * @param {array} removedTexts
     * @param {object} oldHints
     */
    constructor(counter, removedTexts = [], oldHints = []) {
        this.counter = counter;
        this.removedTexts = removedTexts;
        this.oldHints = oldHints;
        this.container = document.getElementById('new_hint_container');
    }

    /**
     * 新しいヒント入力欄を作成
     * @returns {HTMLDivElement}
     */
    createNewBlock() {
        const newFormBlock = document.createElement('div');
        newFormBlock.className = hintBlockClassName;
        return newFormBlock;
    }

    /**
     * 新しいテキストエリアを作成
     * @returns {HTMLTextAreaElement}
     */
    createTextarea() {
        const textarea = document.createElement('textarea');
        textarea.name = `new_hint_text[${this.counter}]`;
        textarea.required = true;
        textarea.value = this.removedTexts.pop() || '';
        textarea.placeholder = 'ヒント本文を入力';
        return textarea;
    }

    /**
     * 新しい画像アップロード部分を作成
     * @returns {HTMLDivElement}
     */
    createDropArea() {
        const uniqueId = `file_element_hint_images[${this.counter}]`;
        const dropArea = document.createElement('div');
        dropArea.className = `drop_area_hint_images[${this.counter}]`;
        dropArea.innerHTML = `
            <p>ここに画像をドロップ、または</p>
            <input type="file" name="new_hint_images[${this.counter}][]" id="${uniqueId}" multiple accept="image/*">
            <label class="button" for="${uniqueId}">ファイルを選択</label>
        `;
        return dropArea;
    }

    /**
     * ヒント入力欄を追加
     * @returns {void}
     */
    add() {
        const maxFields = 5;
        const newFormBlock = this.createNewBlock();
        const textarea = this.createTextarea();
        const dropArea = this.createDropArea();

        if (this.container.children.length <= maxFields) {
            newFormBlock.appendChild(textarea);
            newFormBlock.appendChild(dropArea);
            this.container.appendChild(newFormBlock);
        }
    }

    /**
     * ヒント入力欄を削除
     * @returns {void}
     */
    remove() {
        const lastFormBlock = this.container.lastElementChild;
        // ヒント入力欄がなければ何もしない
        if (!(lastFormBlock && lastFormBlock.className === hintBlockClassName)) {
            return;
        }

        const textarea = lastFormBlock.children[0];
        const textareaValue = textarea.value;
        this.removedTexts.push(textareaValue);
        this.container.removeChild(lastFormBlock);
    }

    /**
     * テキストを表示するpタグを作成
     * @param {string} text
     * @returns
     */
    createP(text) {
        const p = document.createElement('p');
        p.textContent = text;
        return p;
    }

    /**
     * 入力やり直し前のヒントを復元
     * ヒントの数だけ入力欄を作成する
     *
     * コンテナ内ブロックだけを削除しないのは、
     * 入力やり直しの際に、画面が遷移して情報が消えてしまうため
     * @returns {void}
     */
    restoreOldHints() {
        const oldHintsArray = Object.values(this.oldHints);

        // ヒントがなければ何もしない
        if (oldHintsArray.length === 0) {
            return;
        }

        // コンテナ内のブロックを削除
        this.container.innerHTML = '';
        // pタグを作成
        const p = this.createP('新規ヒント');
        // コンテナに追加
        this.container.appendChild(p);
        // ヒントの数だけ入力欄を作成
        oldHintsArray.forEach((hint, hintCounter) => {
            this.counter = hintCounter;
            const textarea = this.createTextarea();
            textarea.value = hint;
            const dropArea = this.createDropArea();

            // ブロックを作成
            const newFormBlock = this.createNewBlock();
            newFormBlock.appendChild(textarea);
            newFormBlock.appendChild(dropArea);
            // ブロックをコンテナに追加
            this.container.appendChild(newFormBlock);
        });
    };
}

const hintBlockClassName = "new_hint_block";

  document.addEventListener('DOMContentLoaded', function() {
    let removedTexts = [];
    let blockCount = document.querySelectorAll(`.${hintBlockClassName}`).length;

    const hintBlock = new HintBlock(blockCount, removedTexts, oldHints);

    // 入力し直しのためのヒント復元
    hintBlock.restoreOldHints();

    // 入力欄の追加
    document.getElementById('add_hint').addEventListener('click', function() {
        blockCount = document.querySelectorAll(`.${hintBlockClassName}`).length;
        hintBlock.counter = blockCount;
        hintBlock.add();
    });

    // 入力欄の削除
    document.getElementById('remove_hint').addEventListener('click', function() {
        blockCount = document.querySelectorAll(`.${hintBlockClassName}`).length;
        hintBlock.counter = blockCount - 1;
        hintBlock.remove();
    });
});
