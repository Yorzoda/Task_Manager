@extends('layout.layout')

@section('content')
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<table class="table table-bordered">
  <thead class=" ">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Заголовок</th>
      <th scope="col">Описание</th>
      <th scope="col">Статус</th>
      <th scope="col">Дата создания</th>
      <th scope="col">Дата измененения</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($tasks as $task)
    <tr>
      <th scope="row">{{$task->id}}</th>
      <td><a href="/tasks/{{$task->id}}">{{$task->title}}</a></td>
      <td>{{$task->description}}</td>
      <td>
        @if($task->status == 1)<div class="btn btn-success"> Активный </div>@endif
        @if($task->status == 2) <div class="btn  btn-dark"> Закончен </div>@endif
        @if($task->status == 3)<div class="btn btn-info "> Неначат </div>@endif
        @if($task->status == 4)<div class="btn btn-secondary"> В очереди </div>@endif
      </td>
      <td>{{date('d.m.Y H:i', strtotime($task->created_at))}}</td>
      <td> @if($task->updated_at == 0 ){{date('d.m.Y H:i', strtotime($task->created_at))}}
        @else {{date('d.m.Y H:i', strtotime($task->updated_at))}}
        @endif
      </td>
      <td>
        @if($task->author == auth()->user()->id)
        <div class="btn-group" role="group" aria-label="Basic example">
          <a href="{{ URL::to('tasks/' . $task->id . '/edit') }}">
            <button type="button" class="btn btn-warning btn-circle btn-sm">Edit <i class="fa fa-pencil-square-o"
                aria-hidden="true"></i>
            </button>
          </a>&nbsp;
          <form action="{{url('tasks', [$task->id])}}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-danger btn-circle btn-sm" value="Delete "> Delete<i
                class="fa fa-trash removeItem"></i></button>
          </form>
        </div>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection