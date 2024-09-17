<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TodoContoller extends Controller
{
    //

    public function index($all_todos)
    {
        if ($all_todos) {
            return DB::select('select * from todo_list');
        } else {
            return DB::select('select * from todo_list where is_completed = ?',[0]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'todo' => 'required|max:255|unique:todo_list,name',
        ]);
        $form_data = $request->all();
        TodoList::create(['name' => $form_data['todo'], 'is_completed' => 0]);
        return redirect('/todo');
    }

    public function update($id)
    {
        TodoList::where('id', $id)->update(['is_completed' => 1]);
        return redirect('/todo');
    }

    public function destroy(Request $request, $id)
    {
        DB::select('delete from todo_list where id = ?',[$id]);
        return redirect('/todo');
    }

    public function showAll()
    {
        $todos = DB::select('select * from todo_list');
        return view('todo', ['todos' => $todos]);
    }

}
