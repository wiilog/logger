import './scss/app.scss';

import '@fortawesome/fontawesome-free';
import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/app.js');

$(".toggle").click(function() {
    const $button = $(this);
    $button.toggleClass("fa-plus fa-minus");
    $button.parent().siblings("ol").toggleClass("d-none");
})

$('.tab-control button').click(function() {
    let button = $(this);

    $(".tab-control button").removeClass("active");
    button.addClass("active");

    $('.tab').hide();
    $(button.data("target")).show();
})