<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Products SPA</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        <link rel="stylesheet" href="/css/app.css">
        <style>
            body{
                background-color: #fff;
            }
        </style>
    </head>
    <body>
        <div id="app">
           <product-component></product-component>
           <vue-progress-bar></vue-progress-bar>



        </div>
            
        
        

    <script src="/js/app.js"></script>    
    </body>
</html>
