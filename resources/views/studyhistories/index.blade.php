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
        <h1>Studyhistory</h1>
        <div class='studyhistories'>
            @foreach ($studyhistories as $studyhistories)
                <div class='studyhistory'>

                </div>
            @endforeach
            {{ Auth::user()->name }}
        </div>
    </body>
</html>
</x-app-layout>