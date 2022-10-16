<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): View
    {
        $statuses = TaskStatus::all()->toArray();
//        $statuses= DB::table('task_statuses')->paginate(15);
        dump($statuses);

        return view('task_statuses.index', [compact($statuses)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request): View
    {
        return view('task_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
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

        return redirect(route('task_statuses.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return Response
     */
    public function show(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return Response
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
        //
    }
}
