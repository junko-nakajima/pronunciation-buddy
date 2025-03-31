<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <title>발음 버디</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </x-slot>
    <body>
        <h1>My Folder</h1>
        @auth
            @if (Auth::user()->is_teacher)
            <a href='/categories/create'>create</a>
            @endif
        @endauth
         <div class='decks'>
            @foreach ($categories as $category)
                <div class='deck'>
                <h2 class='title'>
                    <a href="/categories/{{ $category->id }}">{{ $category->name }}</a>
                </h2>
                @auth
                    @if (Auth::user()->is_teacher)
                        <form action="/categories/{{ $category->id }}" id="form_{{ $category->id }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="deletePost({{ $category->id }})">delete</button>
                        </form>
                        <div class="edit"><a href="/categories/{{ $category->id }}/edit">edit</a></div>
                    @endif
                @endauth
                </div>
            @endforeach
            {{ Auth::user()->name }}
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
            <a href="{{ url()->previous() }}">戻る</a>
        </div>
    </body>
</x-app-layout>