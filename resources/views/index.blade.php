<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <style>
            *{
                box-sizing: border-box;
            }
            body,html{
                width: 100%;
                min-height: 100vh;
                margin:0;
                padding: 0;
            }
            header{
                width: 100%;
                position: fixed;
                top:0;
                left:0;
                padding:15px;
                background: #FFF;
                z-index: 1;
                box-shadow: 1px 0 15px #CCC;
                display: flex;
                align-items: center;
            }
            header a{
                margin-left: 15px;
                text-decoration: none;
            }
            header a.active{
                text-decoration: underline;
            }
            main{
                width: 1000px;
                margin:0 auto;
                padding: 15px;
                padding-top: 65px;
            }
            .tree-item{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <header>
            <x-name/>
            <a href="{{ city_slug() }}/" class="{{ !in_array(last(Request::segments()), ['about','news']) ? 'active' : '' }}">Главная страница</a>
            <a href="{{ city_slug() }}/about" class="{{ last(Request::segments()) == 'about' ? 'active' : '' }}">Страница о нас</a>
            <a href="{{ city_slug() }}/news" class="{{ last(Request::segments()) == 'news' ? 'active' : '' }}">Страница новости</a>
        </header>
        <main>
            {!! $content !!}
        </main>
    </body>
</html>
