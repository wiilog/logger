import "../scss/app.scss";

import "@fortawesome/fontawesome-free";
import $ from "jquery";

$("tr[data-href]").click(function() {
    console.log("ok?");
    window.location.href = $(this).attr("data-href");
})