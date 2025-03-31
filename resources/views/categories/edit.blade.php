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
        <form action="/categories/{{ $category->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class='content__title'>
                <h2>教科書名</h2>
                <input type='text' name='category[name]' value="{{ $category->name }}">
            </div>
            <input type="submit" value="保存">
        </form>
    </div>
</body>
</x-app-layout>