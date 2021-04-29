// TSC --WATCH !!!!!
scrollBottom();
let socket: WebSocket = new WebSocket("ws://127.0.0.1:8080");

$("#submit-message").on("click",(e => {
    e.preventDefault();
    let message: string = ($("#msg").val() as string);
    if(message != ""){
        $.ajax({
            url: "send-message.php",
            type: "POST",
            data: "pseudo=Marc&message="+message,
            error: (err: JQuery.jqXHR, status) => {
                if(err.status == 500){
                    let errorJson: TraitementCode500 = err.responseJSON;
                    console.log(errorJson.error);
                }
            },
            success: (res, status) => {
                let json: TraitementCode200 = res;
                if(json.success){
                    console.log(json.success);
                    sendSocketMessage("New Message");
                    clearInputMessage();
                }
            }
        });
    }
    scrollBottom();
}));

function sendSocketMessage(message: string | object): void{
    if(message as string){
        console.log("string");
        socket.send((message as string));
    } else {
        socket.send(JSON.stringify(message));
    }
}

function isBottomAtScrollBar(): boolean{
    let messages: JQuery<HTMLElement> = $('.chat-messages');
    if(messages.scrollTop() + messages.innerHeight() >= messages[0].scrollHeight){
        return true;
    }
    return false;
}

socket.onmessage = (e: MessageEvent) => {
    let data: string = e.data;
    if(data == 'Reload'){
        let bottom: boolean = isBottomAtScrollBar();
        charger();
    }
}

$("#msg").on("click", ((e: JQuery.ClickEvent<HTMLElement>) => {
    scrollBottom();
}));

function clearInputMessage(){
    $("#msg").val('');
}

function scrollBottom(): void{
    let messages: Element = document.querySelector(".chat-messages");
    messages.scrollTo({top: messages.scrollHeight});
}

function charger(): void{
    let lastId: string = $(".chat-messages div:last-child").attr('id');
    $.ajax({
        url: "get-messages.php?id="+lastId,
        type: "GET",
        success: (html: string) => {
            let messages = document.querySelector(".chat-messages");
            console.log(messages.scrollHeight);
            $(".chat-messages").append(html);
        },
        error: (error: JQuery.jqXHR, status: JQuery.Ajax.ErrorTextStatus) => {
            let errorJson: GetMessageCode400 = error.responseJSON;
            console.log(errorJson.error);
        }
    })

}

type GetMessageCode400 = {
    success: boolean,
    error: string
}

type TraitementCode200 = {
    success: boolean
}

type TraitementCode500 = {
    success: false,
    error: string
}

charger();