$(document).ready(function () {
    const iframeSrc = $("#message_iframe").attr('src');
    const ulIframeSrc = $("#group_user_list_iframe").attr('src');
    const url = window.location.href.split("#")[0];

    $("#user_list .chat-item").click(function (e) {
        if (!$(this).children().hasClass('chattype')) {
            $(this).find('a')[0].click();
        }
    });

    $("#user_list .ct-item").click(function (e) {
        $(this).find('a')[0].click();
    });

    $("#user_list .chat-item-title").click(function (e) {
        if ($(this).siblings(".chattype").css('display') == "none") {
            
            $var = $('.chattype[style*="display: block"]');
            $var.siblings(".chat-item-title").children().click();
            $(".chat-item-title a").unbind("click");
        }


        $(this).siblings(".chattype").slideToggle();
        $chevron = $(this).children().children(".ico-chevron");
        if ($chevron.hasClass("ico-chevron-right")) {
            $chevron.toggleClass("rotated-90");
            $(this).toggleClass('active');
        } else {
            $chevron.toggleClass("rotated--90");
            $(this).toggleClass('active');
        }

        $(this).siblings(".chat-item-footer").css("display", "block");
    });

    $("#user_list .ct-item").click(function (e) {
        $(".ct-item.active").removeClass('active');
        $(this).addClass('active');
    });

    
    $("#chat .ct-item").click(function (e) {
        var name = $(this).find('h6').html();
        var id = $(this).find('a').attr('href').substring(1);

        $("#chat_options").children().attr('hidden', 'hidden');
        $("#message_iframe").attr('chatType', 'chat');
        $("#title").find('h4').html(name);
        $("#message_iframe").attr('src', iframeSrc + '/' + id);
        $("#message_send").attr('targetID', id);

        $("#message_footer #message_send").removeAttr("disabled");

        setTimeout(checkSession, 600);
    });

    $("#group_chat .ct-item").click(function (e) {
        var name = $(this).find('h6').html();
        var id = $(this).find('a').attr('href').substring(1);
        var role = $(this).find('a').attr('role');

        $("#chat_options").children().removeAttr('hidden');
        $("#message_iframe").attr('chatType', 'group_chat');
        $("#title").find('h4').html(name)
        $("#message_iframe").attr('src', iframeSrc + '/group/' + id);
        $("#message_send").attr('targetID', id);

        $("#message_footer #message_send").removeAttr("disabled");

        $("#chat_options").find('li.master').attr('hidden', 'hidden');
        $("#chat_options").find('li.admin').attr('hidden', 'hidden');
        if (role === 'Master') {
            $("#chat_options").find('li.master').removeAttr('hidden');
            $("#chat_options").find('li.admin').removeAttr('hidden');
        } else if (role === 'Admin') {
            $("#chat_options").find('li.admin').removeAttr('hidden');
        }
        
        $("#chat_options").attr('groupID', id);
        
        setTimeout(checkSession, 600);
    });

    $("#dd_show_group_user").click(function (e) { 
        var id = $("#chat_options").attr('groupID');
        var src = ulIframeSrc + "/" + id;
        $("#group_user_list_iframe").attr('src', src)
    });

    $("#message_send").on("input", function (e) { 
        if ($(this).val()) {
            $("#message_footer #send").removeAttr("disabled");
        } else {
            $("#message_footer #send").attr("disabled", 'disabled');
        }
    });

    // Send Message
    $("#send").click(function (e) {
        var chatType = $("#message_iframe").attr('chatType');
        var id = $("#message_send").attr('targetID');
        var message = $("#message_send").val();

        if (message) {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (chatType === 'chat') {
                sendChatMessage(id, message);
            } else if (chatType === 'group_chat') {
                sendGroupChatMessage(id, message);
            }

        } else {
            alert("It seem like you did not enter a message.");
        }
    });


    $("#")
    

    // Search User
    $("#user_util_search #search_button").click(function (e) {
        var id = $("#user_util_search #search_input").val();
        search(id);

        setTimeout(function() {
            checkSession()
    
            window.location.href = url + "#" + id;
            var name = $iframe.contents().find('#username').html();
            $("#title").find('h4').html(name);
        }, 600);
    });

    if (window.location.href.split("#")[1] !== undefined && window.location.href.split("#")[1].length !== 0 ) {
        var id = window.location.href.split("#")[1];
        if ($('#user_list a[href="#' + id + '"]').length > 0) {
            $('#user_list a[href="#' + id + '"]')[0].click();
        } else {
            search(id);

            setTimeout(function() {
                var name = $iframe.contents().find('#username').html();
                $("#title").find('h4').html(name);
            }, 600);
        }
        
    }

    function search(id) {
        $iframe = $("#message_iframe");
    
        $(".chat-item-title.active").children().click();
        $(".ct-item.active").removeClass('active');
    
        $iframe.attr('chatType', 'chat');
        $iframe.attr('src', iframeSrc + '/' + id);
        $("#title").find('h4').html("");
        $("#message_send").attr('targetID', id);
    
        $("#message_footer #message_send").removeAttr("disabled");
    }

});

function checkSession() {
    $iframe = $("#message_iframe").contents();
    if ($iframe.find('#message').length === 0) {
        window.location.reload();
    }
}

function sendChatMessage(id = "", message = "") {
    $.ajax({
        type: "POST",
        url: "/chat/message/send",
        data: {
            'id': id,
            'message': message
        },
        dataType: "json",
        success: function (response) {
            if (response.status === 0) {

                $messageElem = $("#message_template").contents().clone();
                $iframe = $("#message_iframe").contents();
                
                var message = response.message;
                var time = response.time;

                $messageElem.find('.message-container').addClass('send justify-content-end');
                $messageElem.find('.message h6').html(message);
                $messageElem.find('.date small').html(time);
                $iframe.find("#message_content_container").append($messageElem);

                $height = $iframe.find("body").height()

                $iframe.find('html, body').animate({
                    scrollTop: $height
                }, 0);

                if (response.new === true) {
                    window.location.reload();
                }

            } else {
                console.log("Something not right.");
            }
        }
    });
}

function sendGroupChatMessage(id = "", message = "") {
    $.ajax({
        type: "POST",
        url: "/chat/message/group/send",
        data: {
            'id': id,
            'message': message
        },
        dataType: "json",
        success: function (response) {
            if (response.status === 0) {

                $messageElem = $("#message_template").contents().clone();
                $iframe = $("#message_iframe").contents();
                
                var message = response.message;
                var time = response.time;

                $messageElem.find('.message-container').addClass('send justify-content-end');
                $messageElem.find('.message h6').html(message);
                $messageElem.find('.date small').html(time);
                $iframe.find("#message_content_container").append($messageElem);

                $height = $iframe.find("body").height()

                $iframe.find('html, body').animate({
                    scrollTop: $height
                }, 0);

            } else {
                console.log("Something not right.");
                console.log(response);
            }
        }
    });
}