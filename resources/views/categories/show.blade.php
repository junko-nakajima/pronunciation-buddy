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
            {{ $category->name }}
        </h1>
            @foreach($category->decks as $deck)
                    <div class='deck'>
                        <h2 class='title'>
                            <a href="/decks/{{ $deck->id }}">{{ $deck->title }}</a>
                        </h2>
                    </div>
            @endforeach
         <div class="footer">
            <a href="{{ url()->previous() }}">戻る</a>
        </div>
    </body>
</x-app-layout>