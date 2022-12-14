@extends('header')
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  @vite(['resources/css/table.css','resources/css/home.css'])
</head>

<body>
  <section>
    @foreach ($users as $item)
    @if (isset(request()->user) && request()->user->username != $item['username'])
    <div class="container-fluid">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <div class="card text-center">
              <div class="title">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                <h2>{{$item['username']}}</h2>
              </div>
              <a href="/chat/{{$item['id']}}/{{$item['fname']}}">Chat Now </a>
            </div>
          </div>
          @endif
          @endforeach
  </section>
</body>
</html>
