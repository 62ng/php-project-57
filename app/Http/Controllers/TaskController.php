<?php

namespace App\Http\Controllers;

use App\Models\Label;
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
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->paginate(10);

        $creators = User::has('createdTasks')->pluck('name', 'id')->toArray();
        $assignees = User::has('assignedTasks')->pluck('name', 'id')->toArray();
        $statuses = TaskStatus::has('task')->pluck('name', 'id')->toArray();

        $filters = $request->filter ?? null;

        return view('tasks.index', compact('tasks', 'creators', 'assignees', 'statuses', 'filters'));
    }

    public function show(Task $task): View
    {
        return view('tasks.show', compact('task'));
    }

    public function create(): View
    {
        Gate::allowIf(fn () => Auth::check());

        $users = User::pluck('name', 'id')->toArray();
        $statuses = TaskStatus::pluck('name', 'id')->toArray();
        $labels = Label::pluck('name', 'id')->toArray();

        return view('tasks.create', compact('users', 'statuses', 'labels'));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::allowIf(fn () => Auth::check());

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:tasks,name|max:255',
                'description' => 'max:1000',
                'status_id' => 'required',
                'assigned_to_id' => 'nullable',
                'labels' => 'array'
            ],
            [
                'required' => __('interface.required'),
                'unique' => __('interface.task_unique'),
                'max' => __('interface.max'),
            ]
        );

        if ($validator->fails()) {
            return redirect(route('tasks.create'))->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $user = Auth::user();
        $task = $user->createdTasks()->make();
        $task->fill($validated);
        $task->save();

        $labels = collect($validated['labels'])->filter();
        $task->labels()->attach($labels);

        flash(__('interface.task_added'))->success();

        return redirect(route('tasks.index'));
    }

    public function edit(Task $task): View
    {
        Gate::allowIf(fn () => Auth::check());

        $users = User::pluck('name', 'id')->toArray();
        $statuses = TaskStatus::pluck('name', 'id')->toArray();
        $labels = Label::pluck('name', 'id')->toArray();

        return view('tasks.edit', compact('task', 'users', 'statuses', 'labels'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        Gate::allowIf(fn () => Auth::check());

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', Rule::unique('tasks', 'name')->ignore($task->id), 'max:255'],
                'description' => 'max:1000',
                'status_id' => 'required',
                'assigned_to_id' => 'nullable',
                'labels' => 'array'
            ],
            [
                'required' => __('interface.required'),
                'unique' => __('interface.task_unique'),
                'max' => __('interface.max'),
            ]
        );

        if ($validator->fails()) {
            return redirect(route('tasks.create'))->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $task->fill($validated);
        $task->save();

        $task->labels()->detach();
        $labels = collect($validated['labels'] ?? [])->filter();
        $task->labels()->attach($labels);

        flash(__('interface.task_updated'))->success();

        return redirect(route('tasks.index'));
    }

    public function destroy(Task $task): RedirectResponse
    {
        if (! Gate::allows('destroy-task', $task)) {
            abort(403);
        }

        $task->labels()->detach();
        $task->delete();

        flash(__('interface.task_deleted'))->success();

        return redirect(route('tasks.index'));
    }
}
