import $ from "jquery";

$(".toggle").click(function() {
    const $button = $(this);
    $button.toggleClass("fa-plus fa-minus");
    $button.parent().siblings("ol").toggleClass("hidden");
})

$('.tab-control button').click(function() {
    let button = $(this);

    $(".tab-control button").removeClass("active");
    button.addClass("active");

    $('.tab').hide();
    $(button.data("target")).show();
})