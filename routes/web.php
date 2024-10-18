<?php

use Illuminate\Support\Facades\Route;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


Route::get('/', function(){
    $tasks = Task::orderBy('created_at', 'asc')->get();

    //view accepts a second argument,an array of data that is made available to the view

    return view('tasks', [
        'tasks' => $tasks
    ]);
});

Route::post('/task', function(Request $request){
    //validate less than 255
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
    ]);

    if($validator->fails()){
        return redirect('/')
        ->withInput()
        ->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/');

});

Route::delete('/task/{id}', function ($id){
    //retrieve a model by ID or throw a 404 exception if the model does not exist, once model is retrieved, use delete method to delete the record, return 404 ModelNotFoundException
    Task::findOrFail($id)->delete();

    return redirect('/');
});

