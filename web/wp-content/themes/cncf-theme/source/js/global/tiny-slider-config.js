jQuery(
    function ($) {

        var quoteBox = document.getElementsByClassName('quote-box--slides');

        if (quoteBox.length === 0) {
            return;
        }

        var slider = tns(
            {
                container: '.quote-box--slides',
                items: 1,
                slideBy: 'page',
                nav: true,
                controls: false,
                loop: true,
                autoplay: true,
                rewind: true,
                mouseDrag: true,
                center: true,
                autoplayButtonOutput: false,
                animateIn: true,
                autoHeight: true
            }
        );
    }
);
