<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Task extends Model
{
    protected $fillable = ['title','description','status','author','users_id','created_at','updated_at'];
    public $timestamps = true;

 


    public static function getUserTasks($user){
        return DB::table('tasks_ref')
        ->select('tasks.id', 'tasks.title', 'tasks.description', 'tasks.status', 'tasks.author', 'tasks.updated_at','tasks.created_at', 'users.name')
        ->join('tasks','tasks_ref.task_id','=','tasks.id')
        ->join('users','tasks_ref.user_id','=','users.id')
        ->where('users.id', $user)
        ->get();
    }

    public static function insertTask($data){
        return DB::table('tasks')
            ->insertGetId($data);
    }

    public static function insertTaskUser($data){
        DB::table('tasks_ref')
            ->insert($data);
    }
    public static function authorName($id){
        $result = DB::table('users')
            ->select('*')
            ->where('id', $id)
            ->first();
        if(is_null($result)){
            return [];
        } else {
            return $result;
        }
    }
    public static function getAllusers($id){
        return DB::table('tasks_ref')
        ->select('users.name','users.id')
        ->join('users', 'users.id', '=', 'tasks_ref.user_id')
        ->where('tasks_ref.task_id',$id)
        ->get();
    }

}
