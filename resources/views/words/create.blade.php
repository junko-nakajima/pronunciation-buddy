<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <title>발음 버디</title>
    </x-slot>
    <body>
        <h1>Create a Quiz!!</h1>
        <h1>{{ $deck->title }} に単語を追加</h1>
        <form action="/words" method="POST">
            @csrf
            <input type="hidden" name="word[deck_id]" value="{{ $deck->id }}">
            <div class="word">
                <h2>Word</h2>
                <input type="text" name="word[word]" placeholder="単語の間にスペースを入力してください（例：아이 오이" value="{{ old('deck.word')}}"/>
                <p class="word_error" style="color:red">{{ $errors->first('deck.word') }}</p>
            </div>
            <div class="meaning">
                <h2>Meaning</h2>
                <input type="text" name="word[meaning]" placeholder="単語の間にスペースを入力してください（例：こども きゅうり 牛乳" value="{{ old('deck.meaning')}}"/>
                <p class="word_error" style="color:red">{{ $errors->first('deck.word') }}</p>
            </div>
            <input type="submit" value="保存"/>
        </form>
        <div class="back">[<a href="{{ url()->previous() }}">back</a>]</div>
    </body>
</x-app-layout>
