<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <title>발음 버디</title>
    </x-slot>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>발음 버디</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>발음 버디</h1>
        @auth
            @if (Auth::user()->is_teacher)
            <a href='/decks/create'>create</a>
            @endif
        @endauth
            <div class='decks'>
                @foreach($groupedDecks as $categoryName => $decksGroup)
                    <h3>{{ $categoryName }}</h3>
                @foreach ($decksGroup as $deck)
                    <div class='deck'>
                        <h2 class='title'>
                            <a href="/decks/{{ $deck->id }}">{{ $deck->title }}</a>
                        </h2>
                    </div>
                    @auth
                        @if (Auth::user()->is_teacher)
                    <p class='body'>{{ $deck->body }}</p>
                    <form action="/decks/{{ $deck->id }}" id="form_{{ $deck->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePost({{ $deck->id }})">delete</button>
                    </form>
                        @endif
                    @endauth
                @endforeach
                @endforeach
                {{ Auth::user()->name }}
            </div>
        <script>
            function deletePost(id) {
                'use strict'

                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
    </body>
    <div class="back">[<a href="{{ url()->previous() }}">back</a>]</div>
</html>
</x-app-layout>