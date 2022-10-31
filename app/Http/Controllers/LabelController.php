<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LabelController extends Controller
{
    public function index(): View
    {
        $labels = Label::all();

        return view('labels.index', compact('labels'));
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

        return view('labels.create', compact('statuses', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::allowIf(fn () => Auth::check());

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:labels|max:255',
                'description' => 'max:1000',
            ],
            [
                'required' => __('tasks.required'),
                'unique' => __('tasks.unique'),
                'max' => __('tasks.max'),
            ]
        );

        if ($validator->fails()) {
            flash($validator->errors()->first('name'));

            return redirect(route('labels.create'));
        }

        $label = new Label();
        $label->fill($validator->validated());
        $label->save();

        flash(__('interface.label_added'))->success();

        return redirect(route('labels.index'));
    }

    public function edit(Label $label): View
    {
        Gate::allowIf(fn () => Auth::check());

        $statuses = TaskStatus::all()->mapWithKeys(function ($item, $key) {
            return [$item['id'] => $item['name']];
        })->toArray();

        $users = User::all()->mapWithKeys(function ($item, $key) {
            return [$item['id'] => $item['name']];
        })->toArray();

        return view('labels.edit', compact('label', 'statuses', 'users'));
    }

    public function update(Request $request, Label $label): RedirectResponse
    {
        Gate::allowIf(fn () => Auth::check());

        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('labels')->ignore($label->id),
                    'max:255',
                ],
                'description' => 'max:1000',
            ],
            [
                'required' => __('tasks.required'),
                'unique' => __('tasks.unique'),
                'max' => __('tasks.max'),
            ]
        );

        if ($validator->fails()) {
            flash($validator->errors()->first('name'));

            return redirect(route('labels.create'));
        }

        $label->fill($validator->validated());
        $label->save();

        flash(__('interface.label_updated'))->success();

        return redirect(route('labels.index'));
    }

    public function destroy(Label $label): RedirectResponse
    {
        Gate::allowIf(fn () => Auth::check());

        if (Gate::allows('destroy-label', $label)) {
            flash(__('interface.label_not_free'))->error();
        } else {
            $label->delete();

            flash(__('interface.label_deleted'))->success();
        }

        return redirect(route('labels.index'));
    }
}
