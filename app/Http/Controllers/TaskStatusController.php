<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }

    public function index(): View
    {
        $statuses = TaskStatus::orderBy('id')->paginate(10);

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
            'name' => 'required|unique:task_statuses,name|max:255'
            ],
            [
                'required' => __('interface.required'),
                'unique' => __('interface.status_unique'),
                'max' => __('interface.max'),
            ]
        );

        if ($validator->fails()) {
            return redirect(route('task_statuses.create'))->withErrors($validator)->withInput();
        }

        $taskStatus = new TaskStatus();
        $taskStatus->name = $validator->validated()['name'];
        $taskStatus->save();

        flash(__('interface.status_added'))->success();

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
                    Rule::unique('task_statuses', 'name')->ignore($taskStatus->id),
                    'max:255',
                ]
            ],
            [
                'required' => __('interface.required'),
                'unique' => __('interface.status_unique'),
                'max' => __('interface.max'),
            ]
        );

        if ($validator->fails()) {
            return redirect(route('task_statuses.create'))->withErrors($validator)->withInput();
        }

        $taskStatus->name = $validator->validated()['name'];
        $taskStatus->save();

        flash(__('interface.status_updated'))->success();

        return redirect(route('task_statuses.index'));
    }

    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        if ($taskStatus->task()->exists()) {
            flash(__('interface.status_not_free'))->error();

            return back();
        }

        $taskStatus->delete();
        flash(__('interface.status_deleted'))->success();

        return redirect(route('task_statuses.index'));
    }
}
