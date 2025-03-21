<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <title>발음 버디</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </x-slot>
    <body>
        <h1>Lesson Name</h1>
        <a href='/decks/create'>create</a>
         <div class='decks'>
            @foreach ($decks as $deck)
                <div class='deck'>
                <h2 class='title'>
                    <a href="/decks/{{ $deck->id }}">{{ $deck->title }}</a>
                </h2>
                <a href="/categories/{{ $deck->category->id }}">{{ $deck->category->name }}</a>
                    <p class='body'>{{ $deck->body }}</p>
                    <form action="/decks/{{ $deck->id }}" id="form_{{ $deck->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePost({{ $deck->id }})">delete</button>
                    </form>
                </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $decks->links() }}
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
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</x-app-layout>