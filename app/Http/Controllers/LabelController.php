<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }

    public function index(): View
    {
        $labels = Label::orderBy('id')->paginate(10);

        return view('labels.index', compact('labels'));
    }

    public function create(): View
    {
        return view('labels.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:labels,name|max:255',
                'description' => 'max:1000',
            ],
            [
                'required' => __('interface.required'),
                'unique' => __('interface.label_unique'),
                'max' => __('interface.max'),
            ]
        );

        if ($validator->fails()) {
            return redirect(route('labels.create'))->withErrors($validator)->withInput();
        }

        $label = new Label();
        $label->fill($validator->validated());
        $label->save();

        flash(__('interface.label_added'))->success();

        return redirect(route('labels.index'));
    }

    public function edit(Label $label): View
    {
        return view('labels.edit', compact('label'));
    }

    public function update(Request $request, Label $label): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('labels', 'name')->ignore($label->id),
                    'max:255',
                ],
                'description' => 'max:1000',
            ],
            [
                'required' => __('interface.required'),
                'unique' => __('interface.label_unique'),
                'max' => __('interface.max'),
            ]
        );

        if ($validator->fails()) {
            return redirect(route('labels.create'))->withErrors($validator)->withInput();
        }

        $label->fill($validator->validated());
        $label->save();

        flash(__('interface.label_updated'))->success();

        return redirect(route('labels.index'));
    }

    public function destroy(Label $label): RedirectResponse
    {
        if ($label->tasks()->exists()) {
            flash(__('interface.label_not_free'))->error();

            return back();
        }

        $label->delete();
        flash(__('interface.label_deleted'))->success();

        return redirect(route('labels.index'));
    }
}
