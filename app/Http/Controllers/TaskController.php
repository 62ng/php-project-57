<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::all();

        return view('tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        Gate::allowIf(fn () => Auth::check());

        $statuses = TaskStatus::all()->mapWithKeys(function ($item, $key) {
            return [$item['id'] => $item['name']];
        })->toArray();

        $users = User::all()->mapWithKeys(function ($item, $key) {
            return [$item['id'] => $item['name']];
        })->toArray();

        return view('tasks.create', compact('statuses', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::allowIf(fn () => Auth::check());

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:tasks|max:255',
                'status_id' => 'required|integer|min:1',
                'assigned_to_id' => 'integer',
            ],
            [
                'required' => __('tasks.required'),
                'min' => __('tasks.required'),
                'unique' => __('tasks.unique'),
                'max' => __('tasks.max'),
            ]
        );

        if ($validator->fails()) {
            flash($validator->errors()->first('name'));

            return redirect(route('tasks.create'));
        }

        $task = new Task();
        $task->created_by_id = Auth::id();
        $task->fill($validator->validated());
        $task->save();

        flash(__('tasks.task_added'))->success();

        return redirect(route('tasks.index'));
    }

    public function edit(Task $task): View
    {
        Gate::allowIf(fn () => Auth::check());

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        Gate::allowIf(fn () => Auth::check());

        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('tasks')->ignore($task->id),
                    'max:255',
                ]
            ],
            [
                'required' => __('tasks.required'),
                'unique' => __('tasks.unique'),
                'max' => __('tasks.max'),
            ]
        );

        if ($validator->fails()) {
            flash($validator->errors()->first('name'));

            return redirect(route('tasks.create'));
        }

        $task->name = $validator->validated()['name'];
        $task->save();

        flash(__('tasks.task_updated'))->success();

        return redirect(route('tasks.index'));
    }
}
