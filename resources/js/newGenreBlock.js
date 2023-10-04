/**
 * ジャンルの入力欄ブロックを表すクラス
 * @param {number} counter - 入力欄の数
 * @param {array} removedTexts - 削除されたテキスト
 * @param {array} oldGenreText - 入力し直しのための正答
 */
class GenreBlock {
    /**
     * @param {number} counter
     * @param {array} removedTexts
     * @param {object} oldGenreText
     */
    constructor(counter, removedTexts = [], oldGenreText = []) {
        this.counter = counter;
        this.removedTexts = removedTexts;
        this.oldGenreText = oldGenreText;
        this.container = document.getElementById('new_genre_container');
    }

    /**
     * 新しいブロックを作成
     * @returns {HTMLDivElement}
     */
    createNewBlock() {
        const newFormBlock = document.createElement('div');
        newFormBlock.className = genreBlockClassName;
        return newFormBlock;
    }

    /**
     * 新しい入力欄を作成
     * @returns {HTMLDivElement}
     */
    createInput() {
        const input = document.createElement('input');
        input.type = 'text';
        input.value = this.removedTexts.pop() || '';
        input.name = `new_genre_text[${this.counter}]`;
        input.placeholder = '問題のジャンルを入力';
        return input;
    }

    /**
     * ジャンルの入力欄を追加
     */
    add() {
        const newFormBlock = document.createElement('div');
        newFormBlock.className = 'new_genre_block';
        newFormBlock.appendChild(this.createInput());
        this.container.appendChild(newFormBlock);
    }

    /**
     * ジャンルの入力欄を削除
     */
     remove() {
        // 最小数の入力欄は削除しない
        const minFields = 0;
        const remainingBlocks = this.container.querySelectorAll(`.${genreBlockClassName}`).length;
        if (remainingBlocks === minFields) {
            return;
        }

        const lastFormBlock = this.container.lastElementChild;

        const input = lastFormBlock.children[0];
        const inputValue = input.value;
        this.removedTexts.push(inputValue);
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
     * 入力やり直し前のジャンル入力値を復元
     * 正答の数だけ入力欄を作成する
     *
     * コンテナ内ブロックだけを削除しないのは、
     * 入力やり直しの際に、画面が遷移して情報が消えてしまうため
     * @returns {void}
     */
    restoreOldGenreTexts() {
        const oldGenreTextArray = Object.values(this.oldGenreText);

        // 入力がなければ何もしない
        if (oldGenreTextArray.length === 0) {
            return;
        }

        // コンテナ内のブロックを削除
        this.container.innerHTML = '';
        // pタグを作成
        const p = this.createP('新規ジャンル');
        // コンテナに追加
        this.container.appendChild(p);
        // 正答の数だけ入力欄を作成
        oldGenreTextArray.forEach((genreText, genreTextCounter) => {
            this.counter = genreTextCounter;
            const input = this.createInput();
            input.value = genreText;
            // ブロックを作成
            const newFormBlock = this.createNewBlock();
            newFormBlock.appendChild(input);
            // ブロックをコンテナに追加
            this.container.appendChild(newFormBlock);
        });
    };
}


const genreBlockClassName = "new_genre_block";

  document.addEventListener('DOMContentLoaded', function() {
    let removedTexts = [];
    let blockCount = document.querySelectorAll(`.${genreBlockClassName}`).length;

    const genreBlock = new GenreBlock(blockCount, removedTexts, oldGenreText);

    // 入力し直しのための正答復元
    genreBlock.restoreOldGenreTexts();

    // 入力欄の追加
    document.getElementById('add_genre').addEventListener('click', function() {
        blockCount = document.querySelectorAll(`.${genreBlockClassName}`).length;
        genreBlock.counter = blockCount;
        genreBlock.add();
    });

    // 入力欄の削除
    document.getElementById('remove_genre').addEventListener('click', function() {
        blockCount = document.querySelectorAll(`.${genreBlockClassName}`).length;
        genreBlock.counter = blockCount - 1;
        genreBlock.remove();
    });
});
