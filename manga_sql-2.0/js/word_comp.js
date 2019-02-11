//ディスプレイサイズが500以内の18文字以上の文字列を置き換える
w = screen.width;
if (w < 500) {
    var labels = document.getElementsByClassName('list_label');
    var len = labels.length;
    for (var i = 0; i < len; i++) {
        len_str = labels[i].textContent.length;
        if (len_str > 17) {
            t = labels[i].textContent.substr(0, 17) + "...";
            labels[i].innerHTML = t;
        }
    }
}