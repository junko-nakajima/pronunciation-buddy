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
            {{ $category->title }}
        </h1>
        <a href="/categories/{{ $category->category->id }}">{{ $category->name }}</a>
         <div class="footer">
            <a href="/">戻る</a>
        </div>
        <div class="edit"><a href="/categories/{{ $category->id }}/edit">edit</a>
        </div>
    </body>
</x-app-layout>