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



  // $( ".announcement-slider-wrapper" ).slick( {
  //   infinite: true,
  //   slidesToShow: 1,
  //   slidesToScroll: 1,
  //   arrows: true,
  //   dots: false,
  //   autoplay: true,
  //   autoplaySpeed: 10000,
  //   cssEase: "linear",
  //   lazyLoad: "ondemand",
  //   adaptiveHeight: true,
  //   vertical: true,
  //   responsive: [
  //     {
  //       breakpoint: 768,
  //       settings: {
  //         infinite: true,
  //         slidesToShow: 1,
  //         slidesToScroll: 1,
  //         swipeToSlide: true,
  //         draggable: true,
  //         arrows: false,
  //         dots: true,
  //         autoplay: true,
  //         autoplaySpeed: 10000,
  //         cssEase: "linear",
  //         lazyLoad: "ondemand",
  //         adaptiveHeight: false,
  //         vertical: false,
  //       }
  //     }
  //   ]
  // } );
