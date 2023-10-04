/**
 * 正答入力欄ブロックを表すオブジェクト
 * @param {number} counter - 正答入力欄の数
 * @param {array} removedTexts - 削除されたテキスト
 * @param {array} oldAnswers - 入力し直しのための正答
 */
class AnswerBlock {
    /**
     *
     * @param {number} counter
     * @param {array} removedTexts
     * @param {object} oldAnswers
     */
    constructor(counter, removedTexts = [], oldAnswers = []) {
        this.counter = counter;
        this.removedTexts = removedTexts;
        this.oldAnswers = oldAnswers;
        this.container = document.getElementById('new_answer_container');
    }

    /**
     * 新しいブロックを作成
     * @returns {HTMLDivElement}
     */
    createNewBlock() {
        const newFormBlock = document.createElement('div');
        newFormBlock.className = answerBlockClassName;
        return newFormBlock;
    }

    /**
     * 新しいテキストエリアを作成
     * @returns {HTMLTextAreaElement}
     */
    createTextarea() {
        const textarea = document.createElement('textarea');
        textarea.name = `new_answer_text[${this.counter}]`;
        textarea.required = true;
        textarea.value = this.removedTexts.pop() || '';
        textarea.placeholder = '正答本文を入力';
        return textarea;
    }

    /**
     * 新しい画像アップロード部分を作成
     * @returns {HTMLDivElement}
     */
    createDropArea() {
        const uniqueId = `file_element_answer_images[${this.counter}]`;
        const dropArea = document.createElement('div');
        dropArea.className = `drop_area_answer_images[${this.counter}]`;
        dropArea.innerHTML = `
            <p>ここに画像をドロップ、または</p>
            <input type="file" name="new_answer_images[${this.counter}][]" id="${uniqueId}" multiple accept="image/*">
            <label class="button" for="${uniqueId}">ファイルを選択</label>
        `;
        return dropArea;
    }

    /**
     * 正答入力欄を追加
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
     * 既存入力欄があるかチェック
     * @param {HTMLDivElement} parentContainer
     */
    hasExistingAnswerBlock(parentContainer) {
        const existingAnswerBlockClassName = "existing_answer_block";
        const existingAnswerBlock = parentContainer.querySelector(`.${existingAnswerBlockClassName}`);
        if (existingAnswerBlock === null) {
            return false;
        }
        return true;
    }

    /**
     * 正答入力欄を削除
     * @returns {void}
     */
    remove() {
        const parentContainer = this.container.parentElement;
        // 新規正答入力欄の最低数
        let minFields = -1;
        // 既存正答がない場合、新規正答入力欄は最低1個必要
        if (this.hasExistingAnswerBlock(parentContainer) === false) {
            minFields = 1;
        } else {
            // 既存正答がある場合、新規正答入力欄は0個でも良い
            minFields = 0;
        }
        // 残りの正答入力欄の数
        const remainingBlocks = this.container.querySelectorAll(`.${answerBlockClassName}`).length;
        if (remainingBlocks === minFields) {
            return;
        }
        const lastFormBlock = this.container.lastElementChild;

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
     * 入力やり直し前の正答を復元
     * 正答の数だけ入力欄を作成する
     *
     * コンテナ内ブロックだけを削除しないのは、
     * 入力やり直しの際に、画面が遷移して情報が消えてしまうため
     * @returns {void}
     */
    restoreOldAnswers() {
        const oldAnswersArray = Object.values(this.oldAnswers);

        // 正答がなければ何もしない
        if (oldAnswersArray.length === 0) {
            return;
        }

        // コンテナ内のブロックを削除
        this.container.innerHTML = '';
        // pタグを作成
        const p = this.createP('新規正答');
        // コンテナに追加
        this.container.appendChild(p);
        // 正答の数だけ入力欄を作成
        oldAnswersArray.forEach((answer, answerCounter) => {
            this.counter = answerCounter;
            const textarea = this.createTextarea();
            textarea.value = answer;
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

const answerBlockClassName = "new_answer_block";

  document.addEventListener('DOMContentLoaded', function() {
    let removedTexts = [];
    let blockCount = document.querySelectorAll(`.${answerBlockClassName}`).length;

    const answerBlock = new AnswerBlock(blockCount, removedTexts, oldAnswers);

    // 入力し直しのための正答復元
    answerBlock.restoreOldAnswers();

    // 入力欄の追加
    document.getElementById('add_answer').addEventListener('click', function() {
        blockCount = document.querySelectorAll(`.${answerBlockClassName}`).length;
        answerBlock.counter = blockCount;
        answerBlock.add();
    });

    // 入力欄の削除
    document.getElementById('remove_answer').addEventListener('click', function() {
        blockCount = document.querySelectorAll(`.${answerBlockClassName}`).length;
        answerBlock.counter = blockCount - 1;
        answerBlock.remove();
    });
});
