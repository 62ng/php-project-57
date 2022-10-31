<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskStatusController extends Controller
{
    public function index(): View
    {
        $statuses = TaskStatus::all()->toArray();

        return view('task_statuses.index', compact('statuses'));
    }

    public function create(Request $request): View
    {
        Gate::allowIf(fn () => Auth::check());

        return view('task_statuses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::allowIf(fn () => Auth::check());

        $validator = Validator::make(
            $request->all(),
            [
            'name' => 'required|unique:task_statuses|max:255'
            ],
            [
                'required' => __('tasks.required'),
                'unique' => __('tasks.unique'),
                'max' => __('tasks.max'),
            ]
        );

        if ($validator->fails()) {
            flash($validator->errors()->first('name'));

            return redirect(route('task_statuses.create'));
        }

        $taskStatus = new TaskStatus();
        $taskStatus->name = $validator->validated()['name'];
        $taskStatus->save();

        flash(__('interface.status_added'))->success();

        return redirect(route('task_statuses.index'));
    }

    public function edit(TaskStatus $taskStatus): View
    {
        Gate::allowIf(fn () => Auth::check());

        return view('task_statuses.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus): RedirectResponse
    {
        Gate::allowIf(fn () => Auth::check());

        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('task_statuses')->ignore($taskStatus->id),
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

            return redirect(route('task_statuses.create'));
        }

        $taskStatus->name = $validator->validated()['name'];
        $taskStatus->save();

        flash(__('interface.status_updated'))->success();

        return redirect(route('task_statuses.index'));
    }

    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        Gate::allowIf(fn () => Auth::check());

        if (Gate::allows('destroy-status', $taskStatus)) {
            flash(__('interface.status_not_free'))->error();
        } else {
            $taskStatus->delete();

            flash(__('interface.status_deleted'))->success();
        }

        return redirect(route('task_statuses.index'));
    }
}
