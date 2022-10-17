<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        return view('task_statuses.create');
    }

    public function store(Request $request): RedirectResponse
    {
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

        flash(__('tasks.status_added'));

        return redirect(route('task_statuses.index'));
    }
    public function edit(TaskStatus $taskStatus): View
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus): RedirectResponse
    {
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

        flash(__('tasks.status_updated'))->success();

        return redirect(route('task_statuses.index'));
    }

    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        $taskStatus->delete();

        return redirect(route('task_statuses.index'));
    }
}
