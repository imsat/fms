<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = Form::select('id', 'name', 'description')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return $this->response(true, 'Forms list!', 200, $forms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'fields' => 'present|array',
        ]);

        if ($validator->fails()) {
            return $this->response(false, 'Please provide valid information!', 400, $validator->errors());
        }

        $data = $request->except('fields');
        $data['user_id'] = Auth::id();
        try {
            $form = new Form();
            $form->fill($data);
            $form->save();

            if($form){
                $fields = $request->get('fields');
                foreach ($fields as $field){
                    if(!blank($field['label'])){
                        $form->fields()->create([
                            'label' => $field['label']
                        ]);
                    }
                }
                return $this->response(true, 'Created successfully.');
            }

        }catch (\Exception){
            return $this->response(false, 'Something went wrong!!', 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        $form->load('fields:id,form_id,label,field_type');
        return $this->response(true, 'Form with fields', 200, $form);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Form $form)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        //
    }
}
