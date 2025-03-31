<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <title>발음 버디</title>
    </x-slot>
    <body>
        <h1>Make a Folder!!</h1>
        <form action="{{ route(categories.store') }}" method="POST">
            @csrf
            <div class="title">
                <h2>Title</h2>
                <input type="text" name="category[name]" placeholder="フォルダー名" />
            </div>
            <input type="submit" value="保存"/>
        </form>
        <div class="back">[<a href="{{ url()->previous() }}">戻る</a>]</div>
    </body>
</x-app-layout>