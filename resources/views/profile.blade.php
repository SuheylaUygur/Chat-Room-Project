@vite(['resources/css/profile.css'])
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

<h2 style="text-align:center">Profile</h2>

<div class="card">

  <img src="/images/plane-icon.png" alt="John" style="width:100%">
  @if (isset(request()->user))
  <h1>{{request()->user->fname." ".request()->user->lname}}</h1>



  <p class="title">{{request()->user->username}}</p>
  <p>{{request()->user->email}}</p>

  <p><a href="/home"><button>Home</button></a></p>
  @endif
</div>

</body>
</html>
