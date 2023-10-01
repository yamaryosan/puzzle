document.addEventListener('DOMContentLoaded', function() {
    // ヒントの復元
    if (oldHints.length > 0) {
        var hintsDiv = document.getElementById('hints');
        hintsDiv.innerHTML = ''; // ヒントをクリア
        oldHints.forEach(function(hint) {
            var textarea = document.createElement('textarea');
            textarea.name = 'hints[]';
            textarea.required = true;
            textarea.value = hint;
            hintsDiv.appendChild(textarea);
        });
    }
});
