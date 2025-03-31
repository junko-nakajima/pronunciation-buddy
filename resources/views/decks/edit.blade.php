<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <title>발음 버디</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </x-slot>
<body>
    <h1 class="title">編集画面</h1>
    <div class="content">
        <form action="/decks/{{ $deck->id }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="deck[user_id]" value="{{ $deck->user_id }}">
            <input type="hidden" name="deck[category_id]" value="{{ $deck->category_id }}">
            <div class='content__title'>
                <h2>タイトル</h2>
                <input type='text' name='deck[title]' value="{{ $deck->title }}">
            </div>
            <input type="submit" value="保存">
        </form>
    </div>
</body>