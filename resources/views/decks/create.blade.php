<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <title>발음 버디</title>
    </x-slot>
    <body>
        <h1>Create a Quiz!!</h1>
        <form action="/decks" method="POST">
            @csrf
            <input type="hidden" name="deck[category_id]" value="{{ $category->id }}">
            <div class="title">
                <h2>Title</h2>
                <input type="text" name="deck[title]" placeholder="タイトル" />
            </div>
            <input type="submit" value="保存"/>
        </form>
        <div class="back">[<a href="{{ url()->previous() }}">back</a>]</div>
    </body>
</x-app-layout>
