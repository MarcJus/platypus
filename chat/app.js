//TSC --WATCH !!!!!
scrollBottom();
var socket = new WebSocket("ws://127.0.0.1:8080");
$("#submit-message").on("click", (function (e) {
    e.preventDefault();
    var message = $("#msg").val();
    if (message != "") {
        $.ajax({
            url: "send-message.php",
            type: "POST",
            data: "pseudo=Marc&message=" + message,
            error: function (err, status) {
                if (err.status == 500) {
                    var errorJson = err.responseJSON;
                    console.log(errorJson.error);
                }
            },
            success: function (res, status) {
                var json = res;
                if (json.success) {
                    console.log(json.success);
                    sendSocketMessage("New Message");
                    clearInputMessage();
                }
            }
        });
    }
    scrollBottom();
}));
function sendSocketMessage(message) {
    if (message) {
        console.log("string");
        socket.send(message);
    }
    else {
        socket.send(JSON.stringify(message));
    }
}
function isBottomAtScrollBar() {
    var messages = $('.chat-messages');
    if (messages.scrollTop() + messages.innerHeight() >= messages[0].scrollHeight) {
        return true;
    }
    return false;
}
socket.onmessage = function (e) {
    var data = e.data;
    if (data == 'Reload') {
        var bottom = isBottomAtScrollBar();
        charger();
    }
};
$("#msg").on("click", (function (e) {
    scrollBottom();
}));
function clearInputMessage() {
    $("#msg").val('');
}
function scrollBottom() {
    var messages = document.querySelector(".chat-messages");
    messages.scrollTo({ top: messages.scrollHeight });
}
function charger() {
    var lastId = $(".chat-messages div:last-child").attr('id');
    $.ajax({
        url: "get-messages.php?id=" + lastId,
        type: "GET",
        success: function (html) {
            var messages = document.querySelector(".chat-messages");
            console.log(messages.scrollHeight);
            $(".chat-messages").append(html);
        },
        error: function (error, status) {
            var errorJson = error.responseJSON;
            console.log(errorJson.error);
        }
    });
}
charger();
