<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

use App\Task;

class TasksController extends Controller
{
  public function index()
  {
    $tasks = Task::all();

    return Response::json(['tasks' => $tasks])
  }

  public function store(Request $request)
  {
    $rules = [
      'taskContent' => 'required'
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
    {
      return Response::json(['error' => 'Please fill out all fields.']);
    }

    $taskContent = $request->input('taskContent');

    $task = new Task;
    $task->taskContent = $taskContent;
    $task->save();

    return Response::json(['task' => $task]);
  }

  public function show($id)
  {
    $task = Task::find($id);

    //$task = Task::where('id', '=', $id)->get();

    return Response::json(['task' => $task]);
  }
}
