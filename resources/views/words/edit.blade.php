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
        <form action="/words/{{ $word->id }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="word[deck_id]" value="{{ $word->deck_id }}">
            <div class='content__title'>
                <h2>単語</h2>
                <input type='text' name='word[word]' value="{{ $word->word }}">
            </div>
            <div class='content__meaning'>
                <h2>意味</h2>
                <input type='text' name='word[meaning]' value="{{ $word->meaning }}">
            </div>
            <input type="submit" value="保存">
        </form>
    </div>
</body>