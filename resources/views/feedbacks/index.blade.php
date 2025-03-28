<x-app-layout>
    <x-slot name="header">
        <meta charset="utf-8">
        <title>발음 버디</title>
    </x-slot>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>발음 버디</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>Feedback</h1>
        <div class='feedbacks'>
            @foreach ($feedbacks as $feedbacks)
                <div class='feedback'>
                    <h2 class='score'>{{ $feedback->score }}</h2>
                    <p class='comment'>{{ $feedback->comment }}</p>
                </div>
            @endforeach
            {{ Auth::user()->name }}
        </div>
    </body>
</html>
</x-app-layout>