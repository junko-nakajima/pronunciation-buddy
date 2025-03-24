<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <title>발음 버디</title>
    </x-slot>
    <body>
        <h1>{{ $deck->title }}</h1>
        <a href='/words/create'>create</a>
        <form action="/words" method="POST">
            @csrf
            <div class="word">
                <h2>word</h2>
                <input type="text" name="word[word]" placeholder="単語"/>
            </div>
            <div class="meaning">
                <h2>meaning</h2>
                <textarea name="word[meaning]" placeholder="意味"></textarea>
            </div>
            <input type="submit" value="store"/>
        </form>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</html>
</x-app-layout>