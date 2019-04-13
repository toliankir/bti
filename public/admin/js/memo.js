function showMemo(section) {
    const $body = $('body');
    const $memo = $('<div class="memo"></div>');
    if (!$body.has($('.memo')).length) {
        $body.append($memo);
    }
    $memo.css('opacity', 0);
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
                .animate({opacity: 0.9},200);
        });

    $memoElement
        .on('mouseleave', () => {
            $memo.animate({opacity: 0},200);
        });

}

