//TSC --WATCH !!!!!
scrollBottom();
$("#submit").on("click", (function (e) {
    e.preventDefault();
    var message = $("#message").val();
    if (message != "") {
        $.ajax({
            url: "traitement.php",
            type: "POST",
            data: "pseudo=Marc&message=" + message,
            dataType: "application/json",
            success: function (response, status) {
                console.log(status);
                console.log(response);
            }
        });
        $.ajax({
            url: "index.php?update=true",
            type: "GET",
        });
    }
    scrollBottom();
}));
$("#message").on("click", (function (e) {
    scrollBottom();
}));
function scrollBottom() {
    var messages = document.querySelector("#messages");
    messages.scrollTo({ top: messages.scrollHeight });
}
function charger() {
    setTimeout(function () {
        var lastId = $("#messages p:last-child").attr('id');
        $.ajax({
            url: "get-messages.php?id=" + lastId,
            type: "GET",
            success: function (html) {
                $("#messages").append(html);
            }
        });
        charger();
    }, 100);
}
// charger();
