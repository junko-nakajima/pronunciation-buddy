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
            {{ $deck->title }}
        </h1>
        <a href="/categories/{{ $deck->category->id }}">{{ $deck->category->name }}</a>
        <div class="content">
            <div class="content__deck">
                <h3>本文</h3>
            </div>
        </div>        
        <div class="footer">
            <a href="{{ url()->previous() }}">戻る</a>
        </div>
        <div class="edit"><a href="/decks/{{ $deck->id }}/edit">edit</a>
        </div>
    </body>
</x-app-layout>