<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Categories</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </x-slot>
    <body>
        <h1 class="title">
        @auth
            @if (Auth::user()->is_teacher)
            <a href='/categories/create'>create</a>
            @endif
        @endauth
            {{ $category->name }}
        </h1>
            @foreach($category->decks as $deck)
                    <div class='deck'>
                        <h2 class='title'>
                            <a href="/decks/{{ $deck->id }}">{{ $deck->title }}</a>
                        </h2>
                    </div>
                    @if (Auth::user()->is_teacher)
                        <form action="/decks/{{ $deck->id }}" id="form_{{ $deck->id }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="deletePost({{ $deck->id }})">delete</button>
                        </form>
                        <div class="edit"><a href="/decks/{{ $deck->id }}/edit">edit</a></div>
                    @endif
            @endforeach
         <div class="footer">
            <a href="{{ url()->previous() }}">戻る</a>
        </div>
        <script>
            function deletePost(id)
            {
                'use strict'

                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
    </body>
</x-app-layout>