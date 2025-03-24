<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Decks</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </x-slot>
    <body>
        <h1 class="title">
            {{ $word->title }}
        </h1>
        <a href="/categories/{{ $deck->category->id }}">{{ $deck->category->name }}</a>
        <div class="content">
            <div class="content__word">
                <h3>意味</h3>
            </div>
        </div>        
        <div class="footer">
            <a href="/">戻る</a>
        </div>
        <div class="edit"><a href="/words/{{ $word->id }}/edit">edit</a>
        </div>
    </body>
</x-app-layout>