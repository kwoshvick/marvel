<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('index.css') }} ">
    <title>Marvel Characters!</title>
</head>
<body class="page-background">
<div class="container">
    <div class="row page-title-container">
        <h3 class="page-title">MCU Characters</h3>
    </div>
    <div class="row gy-4">
        @foreach( $characters as $character)
            <div class="col-sm-12 col-md-3 col-lg-2">
                <img class="character-thumbnail" src="{{$character->thumbnail}}" />
                <p class="title">{{$character->name}}</p>
                <div class="comic-series-container">
                    <span class="series">Comics: 12</span>
                    <span class="series">Series: 3</span>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-sm-12 offset-md-1 col-md-3 offset-lg-3 col-lg-6 pagination-container" style="margin-top: 50px">
        {{$characters->links()}}
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
