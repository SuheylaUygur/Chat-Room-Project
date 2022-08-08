@php

if (!isset($id)) {
    echo 'burada!';
} else {
    global $outgoing_id;

    global $incoming_id;
    $outgoing_id = $id;
    if (isset(request()->user)) {
        $incoming_id = request()->user->id;
    }
}
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laravel Project Chat Room</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>
    @vite(['resources/css/chat.css', 'resources/css/alert.css'])

</head>

<body>
    <div class="wrapper">
        <section class="chat-area">

            <header>
                <a href="/home" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="/images/plane-icon.png">
                <div class="details">
                    <span>{{ $fname }}</span>
                    <p>Active Now</p>
                </div>
            </header>

            <div class="chat-box" id="myDiv">
                <div class="chat outgoing">
                    <div class="details">
                        <table id='table'>
                        </table>
                    </div>
                </div>

            </div>
            <form id="message-form" action="" class="typing-area" method="POST">
                @csrf
                <input type="text" name="text" id="text" placeholder="Type a message here...">
                <button id="driver"><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
    <script>
        $(document).ready(function() {

            setInterval(function(){

                $("#myDiv").animate({
                scrollTop: $('#myDiv')[0].scrollHeight * 4
            });


            //////////////////////////////////////////////////////////

            var dataString = $("#message-form").serialize();
            // setInterval(function() { document.getElementById("table").innerHTML += "Hello"}, 1000);
            // page load
            $.ajax({
                type: "POST",
                url: "/chat/get/{{ $outgoing_id }}",
                data: dataString,
                success: function(data) {

                    $("#table").html('');

                    res = JSON.stringify(data);

                    var stringify = JSON.parse(res);
                    var symbol_up = '<h4 style="color:red;">&#8648;';
                    var symbol_down = '<h4 style="color:black; ">&#8650;';
                    for (var i = 0; i < stringify.length; i++) {
                        if (stringify[i]['incoming_msg_id'] === {{ $incoming_id }}) {
                            document.getElementById("table").innerHTML += symbol_up + stringify[i]['msg'] +
                            " "+stringify[i]['created_at']  + '<a href="/delete/'+stringify[i]['id']+'" class="button">  Delete Message</a>' + '<br>';
                        } else {
                            document.getElementById("table").innerHTML += symbol_down + stringify[i]['msg'] +
                            " "+stringify[i]['created_at'] + '<a href="/delete/'+stringify[i]['id']+'" class="button">  Delete Message</a>' + '<br>';
                        }
                    };
                }
            });

            }, 3000);

        });


        //////////////////////////////////////////////////////////

        // message add

        $("#driver").click(function(e) {
            var dataString = $("#message-form").serialize();


            $.ajax({
                type: "POST",
                url: "/chat/store/{{ $outgoing_id }}",
                data: dataString,
                success: function(data) {

                    let msg = $('<h4 />')
                        .css('color', 'red')
                        .html('&#8648;' + data.msg);

                    $('#table').append(msg);

                    $('#text').val('');

                }
            });
            e.preventDefault();
        });
    </script>
</body>

</html>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
