document.addEventListener('DOMContentLoaded', function() {
    // 正答の復元
    if (oldAnswers.length > 0) {
        var answersDiv = document.getElementById('answers');
        answersDiv.innerHTML = ''; // ヒントをクリア
        oldAnswers.forEach(function(answer) {
            var textarea = document.createElement('textarea');
            textarea.name = 'answers[]';
            textarea.required = true;
            textarea.value = answer;
            answersDiv.appendChild(textarea);
        });
    }
});
