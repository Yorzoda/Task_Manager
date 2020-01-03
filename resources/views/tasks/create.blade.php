@extends('layout.layout')

@section('content')
<div class="row">
    <h1>Добавить Задачу </h1>

</div>


<div id="title" class="form-group row">

    <label for="title">Заголовок</label>
    <input type="text" class="form-control" id="taskTitle" name="title">
</div>

<div style="" id="status" class="form-group row">
    <label for="status">Статус:</label>
    <select class="form-control" id="taskStatus" name="status">
        <option value="1">Активный</option>
        <option value="2">Закончен</option>
        <option value="3">Неначат</option>
        <option value="4">В очереди</option>
    </select>
</div>

<div class="form-group row">
    <label for="description">Описание</label>
    <textarea type="text" class="form-control" rows="3" name="description" id="taskDescription"></textarea>
</div>

<div id="resultAdd" class="form-group row ">

    <div class="col-12 resultAdd">
        <div class="item btn btn-success " data-id="{{ auth()->user()->id }}">{{ auth()->user()->name }}</div>

    </div>


    <div class="col-12">
        <div class="pickUsers  ">
            <input id="userAdd" class=" form-control col" type="text" name="ref" autocomplete="off"
                placeholder="Search">
        </div>
    </div>
    <div class="col-12">

        <div class="result  "></i></div>

    </div>

</div>

</div>
</div>
@if ($errors->any())
<div class="alert alert-andger">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</div>
@endif
<div class="row">
    <button onClick="saveTask()" class="btn btn-primary">Добавить</button>
</div>
</div>

@endsection