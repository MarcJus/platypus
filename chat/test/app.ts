//TSC --WATCH !!!!!
scrollBottom();

$("#submit").on("click",(e => {
    e.preventDefault();
    let message: string = ($("#message").val() as string);
    if(message != ""){
        $.ajax({
            url: "traitement.php",
            type: "POST",
            data: "pseudo=Marc&message="+message,
            dataType: "application/json",
            success: (response, status: JQuery.Ajax.SuccessTextStatus) => {
                console.log(status);
                console.log(response);
            }
        });
        $.ajax({
            url: "index.php?update=true",
            type: "GET",
        })
    }
    scrollBottom();
}));

$("#message").on("click", ((e: JQuery.ClickEvent<HTMLElement>) => {
    scrollBottom();
}));

function scrollBottom(): void{
    let messages: Element = document.querySelector("#messages");
    messages.scrollTo({top: messages.scrollHeight});    
}

function charger(): void{
    setTimeout(() => {
        let lastId: string = $("#messages p:last-child").attr('id');
        $.ajax({
            url: "get-messages.php?id="+lastId,
            type: "GET",
            success: (html) => {
                $("#messages").append(html);
            }
        })

        charger();
    }, 100)
}

// charger();