@extends('layout.layout')

@section('content')
<h1>Showing Task {{ $task->title }}</h1>

<div class="jumbotron text-center">
    <p>
        <strong>Заголовок:</strong> {{ $task->title }}<br>
        <strong>Описание:</strong> {{ $task->description }}<br>
        <strong>Автор:</strong> {{ $user->name }}<br>
        <strong>Статус:</strong>
        @if($task->status == 1) Активный @endif
        @if($task->status == 2) Закончен @endif
        @if($task->status == 3) Неначат @endif
        @if($task->status == 4) В очереди @endif
        <br>
        <strong>Пользователи:</strong>
        @if(!$Users)Нет других пользователей! @endif
        @foreach ($Users as $index => $user)
        @if($user->id !== $task->author)
        {{$user->name}}@if($index < count($Users) - 1), @endif @endif @endforeach </p> </div> @endsection