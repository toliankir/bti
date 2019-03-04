const $headerMenu = $('.header-menu');

const $slider = $('.slider');
const $sliderControl = $('.slider-control');
const sliderItemClass = '.slider-item';
let mouseOnSlideControl = false;
let $sliders = {};
let currentSlide = 0;


$(document).ready(() => {
    $headerMenu.find('.menu-item').each((id, el) => {
        const $element = $(el);
        const $subMenuElemet = $(el).children('.sub-menu-element');
        if ($subMenuElemet.length === 0 || $(window).width() < 400) {
            return;
        }

        $element.on('mouseenter', () => {
            $subMenuElemet
                .css('left', -1)
                .css('top', $element.height())
                .show();
        });

        $element.on('mouseleave', () => {
            $subMenuElemet.hide();
        });
    });

    sliderInit();
});

function sliderInit() {
    $sliders = $(sliderItemClass);
    $sliders.each((ind, element) => {
        $sliderControl.append($('<i class="fas fa-dot-circle control"></i>')
            .on('mouseenter', () => {
                currentSlide = ind;
                setSlide(currentSlide);
                mouseOnSlideControl = true;
            })
            .on('mouseleave', () => {
                mouseOnSlideControl = false;
            }))
    });
    currentSlide = 0;
    $slider.html($sliders[currentSlide]);
    setInterval( () => {
        if (mouseOnSlideControl) {
            return;
        }
        setSlide(nextSlide());
    }, 10000);
}

function nextSlide() {
    if (++currentSlide === $sliders.length) {
        currentSlide = 0;
    }
    return currentSlide;
}

function setSlide(slideId) {
    const $slide = $($sliders[slideId]);
    $slider.append($slide.css('opacity', 0));
    $slide.animate({'opacity': 1}, 1000);
}


