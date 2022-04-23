// phpcs:ignorefile
jQuery(document).ready(function( $ ) {

	jQuery( ".home-projects-slider-item-1" ).slick( {
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    swipeToSlide: false,
    draggable: false,
    arrows: false,
    autoplay: true,
    appendArrows: false,
    autoplaySpeed: 0,
    cssEase: "linear",
    centerMode: true,
    variableWidth: true,
    lazyLoad: "ondemand",
    speed: 4500
  } );

  jQuery( ".home-projects-slider-item-2" ).slick( {
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    swipeToSlide: false,
    draggable: false,
    arrows: false,
    autoplay: true,
    appendArrows: false,
    autoplaySpeed: 0,
    cssEase: "linear",
    centerMode: true,
    variableWidth: true,
    lazyLoad: "ondemand",
    initialSlide: 6,
    speed: 5000,
    rtl: true
  } );


});
