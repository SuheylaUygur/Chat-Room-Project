@php

if (!isset($id)) {
    echo 'write localhost/login';
    die();
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
        $("#myDiv").animate({
            scrollTop: $('#myDiv')[0].scrollHeight * 4
        });


        $(document).ready(function() {
            // FETCHING DATA FROM JSON FILE
            $.getJSON("/chat/data", function(data) {
                var space = '';
                var symbol_up =
                    '<h4 style="color:red; margin-right:0px; float:right; text-align:right">&#8648;';
                var symbol_down =
                    '<h4style="color:black; margin-left:0px; float:left; text-align:left; ">&#8650;';
                var forward = '(';
                var back = ')';

                // ITERATING THROUGH OBJECTS
                $.each(data, function(key, value) {

                    // gönderilen mesajlar
                    if ((value.incoming_msg === "{{ $incoming_id }}" &&
                            value.outgoing_mdg === "{{ $outgoing_id }}")) {

                        space = space + '<tr>';
                        space = space + '<td>' + symbol_up + forward + value.text + back + '</td>';
                        space = space + '<td>' + value.datetime_submitted + '</td>';

                        //space = space + '<td>' +'<a href="/control?id=<?php echo $incoming_id; ?>"  class="button">delete message!</a> <p id="demo"></p>' + '</td>';
                        space = space + '<tr>';
                    }

                    // alınan mesajlar
                    if ((value.incoming_msg === "{{ $outgoing_id }}" &&
                            value.outgoing_mdg === "{{ $incoming_id }}")) {


                        space = space + '<tr>';
                        space = space + '<td>' + symbol_down + forward + value.text + back +
                            '</td>';
                        space = space + '<td>' + value.datetime_submitted + '</td>';

                        space = space + '<tr>';
                    }
                });
                //INSERTING ROWS INTO TABLE
                $('#table').append(space);
            });

            $("#driver").click(function(e) {
                var dataString = $("#message-form").serialize();

                $.ajax({
                    type: "POST",
                    url: "/chat/store/{{ $outgoing_id }}",
                    data: dataString,
                    success: function(data) {
                        if (typeof data.error === 'undefined')
                            location.reload();
                    }
                });
                e.preventDefault();
            });

        });

        function myFunction() {
            // mesaj silinecek !
            // data = {
            //     id: incoming_msg,
            //     _method: 'delete'
            // };
            // url = '/control'
            // request = $.post(url, data);
            // request.done(function(res) {
            //     alert('Yupi Yei. Message has been deleted')
            // });
        }
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
