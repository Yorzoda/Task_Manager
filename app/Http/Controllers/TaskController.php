<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\User;
use Auth;
use App;
use Carbon\Carbon;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {  
        $tasks = App\Task::getUserTasks(Auth::user()->id);
        // dd($tasks);
        return view('tasks.index',compact('tasks',$tasks));
        }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
   
       return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $current_date_time = Carbon::now()->toDateTimeString(); 
        $AId = Auth::getUser()->id;
        $request->validate([
            'title' => 'required|min:3',
            'description' => 'required',
            'status'=>'required',
        ]);
        $taskId = App\Task::insertTask([
            'title' => $request->title,
            'description' => $request->description,
            'status'=>$request->status,
            'author'=>$AId,
            'created_at'=> $current_date_time,
            ]);
        if($request->users){
            foreach($request->users as $user){
                App\Task::insertTaskUser([
                    'task_id' => $taskId,
                    'user_id' => $user
                ]);
            }
        }
        
        return json_encode(['id' => $taskId]);
        // return "Status OK";
        // return redirect('/tasks/'.$task->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $All = Task::getAllusers($task->id);   
        $userName = Task::authorName($task->author);
        return view('tasks.show',['task'=>$task,'user'=> $userName,'Users'=>$All]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('tasks.edit',compact('task',$task));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    { 
        $current_date_time = Carbon::now()->toDateTimeString();   
        $request->validate([
        'title' => 'required|min:3',
        'description' => 'required',
    ]);
    
    $task->title = $request->title;
    $task->description = $request->description;
    $task->status = $request->status;
    $task->updated_at = $current_date_time;
    $task->save();
    $request->session()->flash('message', 'Successfully modified the task!');
    return redirect('tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,Task $task)
    {
        $task->delete();
        $request->session()->flash('message', 'Successfully deleted the task!');
        return redirect('tasks');
    }
    public function find($name){
        $find =User::findUSers($name);
        return json_decode($find);
    }

}


