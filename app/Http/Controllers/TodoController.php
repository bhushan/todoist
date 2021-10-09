<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    public function index()
    {
        return view('todos.index', [
            'todos' => Todo::all()
        ]);
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        auth()
            ->user()
            ->todos()
            ->create($request->validate([
                'body' => ['required', 'max:200'],
            ]));

        return redirect(route('todos.index'));
    }

    public function show(Todo $todo)
    {
        //
    }

    public function edit(Todo $todo)
    {
        //
    }

    public function update(Request $request, Todo $todo)
    {
        //
    }

    public function destroy(Todo $todo)
    {
        abort_if($todo->owner->isNot(auth()->user()), Response::HTTP_FORBIDDEN);

        $todo->delete();

        return redirect(route('todos.index'));
    }

    public function toggleStatus(Todo $todo)
    {
        abort_if($todo->owner->isNot(auth()->user()), Response::HTTP_FORBIDDEN);

        $todo->is_completed = !$todo->is_completed;
        $todo->save();

        return redirect(route('todos.index'));
    }
}
