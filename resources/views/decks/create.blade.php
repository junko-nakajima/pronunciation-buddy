<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <title>발음 버디</title>
    </x-slot>
    <body>
        <h1>Create a Quiz!!</h1>
        <form action="/decks" method="POST">
            @csrf
            <div class="category">
            <h2>Category：カテゴリーを選択してください</h2>
            <select name="deck[category_id]">
                @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            </div>
            <div class="title">
                <h2>Title</h2>
                <input type="text" name="deck[title]" placeholder="タイトル" value="{{ old('deck.title')}}"/>
                <p class="title_error" style="color:red">{{ $errors->first('deck.title') }}</p>
            </div>
            <input type="submit" value="保存"/>
        </form>
        <div class="back">[<a href="{{ url()->previous() }}">back</a>]</div>
    </body>
</x-app-layout>
