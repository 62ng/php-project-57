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
    public function index(Request $request): View|RedirectResponse
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
        $statuses = TaskStatus::all()->pluck('name', 'id')->toArray();

        return view('tasks.show', compact('task', 'statuses'));
    }

    public function create(): View
    {
        Gate::allowIf(fn () => Auth::check());

        $users = User::all()->pluck('name', 'id')->toArray();
        $statuses = TaskStatus::all()->pluck('name', 'id')->toArray();
        $labels = Label::all()->pluck('name', 'id')->toArray();

        return view('tasks.create', compact('users', 'statuses', 'labels'));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::allowIf(fn () => Auth::check());

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:tasks|max:255',
                'description' => 'max:1000',
                'status_id' => 'required|integer|min:1',
                'assigned_to_id' => 'integer',
                'labels' => 'array',
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

        $users = User::all()->pluck('name', 'id')->toArray();
        $statuses = TaskStatus::all()->pluck('name', 'id')->toArray();
        $labels = Label::all()->pluck('name', 'id')->toArray();

        return view('tasks.edit', compact('task', 'users', 'statuses', 'labels'));
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
                ],
                'description' => 'max:1000',
                'status_id' => 'required|integer|min:1',
                'assigned_to_id' => 'integer',
                'labels' => 'array',
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

        $validated = $validator->validated();

        $task->fill($validated);
        $task->save();

        $task->labels()->detach();
        $labels = collect($validated['labels'])->filter();
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
