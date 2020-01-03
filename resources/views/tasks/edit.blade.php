@extends('layout.layout')

@section('content')
<div class="row">
  <h1>Edit Task</h1>
</div>
<form action="{{url('tasks', [$task->id])}}" method="POST">
  <input type="hidden" name="_method" value="PUT">
  {{ csrf_field() }}
  <div style="" id="title" class="form-group row">

    <label for="title">Заголовок:</label>
    <input type="text" value="{{$task->title}}" class="form-control" id="taskTitle" name="title">
  </div>

  <div class="form-group row">
    <label for="status">Статус: </label>
    <select class="form-control " id="" name="status">
      <option value="1">Активный</option>
      <option value="2">Закончен</option>
      <option value="3">Неначат</option>
      <option value="4">В очереди</option>
    </select>
  </div>

  <div class="form-group row">
    <label for="description">Описание</label>
    <textarea type="text" value="{{$task->description}}" class="form-control" id="taskDescription"
      name="description">{{$task->description}}</textarea>
  </div>

  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <div class="row">
    <button type="submit" class="btn btn-primary btn-circle btn-sm">Изменить</button>
  </div>
</form>
@endsection