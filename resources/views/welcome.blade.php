<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href={{mix("/css/app.css")}}>
</head>

<body class="antialiased">
    <div id="app">
        <product-component />
    </div>

    <script src={{mix("/js/app.js")}}></script>
    <script src="https://kit.fontawesome.com/2c87f61656.js" crossorigin="anonymous"></script>
</body>

</html>
