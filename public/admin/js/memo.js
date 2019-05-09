function showMemo(section = '.main-content') {
    const $body = $('body');
    const $memo = $('<div class="memo"></div>');
    if (!$body.has($('.memo')).length) {
        $body.append($memo);
    }
    $memo.hide();
    const ARROW_HEIGHT = 8;
    const $memoElement = $(`${section} [data-memo]`);
    $memoElement
        .on('mouseenter', (element) => {
            let $element = $(element.target);
            if (!$element.attr('data-memo')) {
                $element = $element.closest($('[data-memo]'));
            }
            const position = $element.offset();
            const elementText = $element.attr('data-memo');
            $memo
                .text(elementText)
                .css('top', position.top - $memo.outerHeight() - ARROW_HEIGHT)
                .css('left', position.left)
                .show();
        });

    $memoElement
        .on('mouseleave', () => {
            $memo.hide();
        });

}

