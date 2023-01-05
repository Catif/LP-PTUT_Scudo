<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Scudo - Flux vidéo</title>

        @vite('resources/assets/css/main.css')
    </head>
    <body>

        <div id="app"></div>
        
        @vite('resources/main.js')
    </body>
</html>
