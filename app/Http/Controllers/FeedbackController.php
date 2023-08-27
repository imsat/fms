<?php

namespace App\Http\Controllers;

use App\Mail\NewFeedback;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $formId = $request->get('id');
        $fields = $request->get('fields');

        $checkExists = DB::table('feedbacks')
            ->where('user_id', $userId)
            ->where('form_id', $formId)
            ->first();

        if(!empty($checkExists)){
            return $this->response(false, 'Feedback already submitted!!', 400);
        }

        $feedbackData = [];
        foreach ($fields as $key => $field) {
            $feedbackData[$key]['user_id'] = $userId;
            $feedbackData[$key]['form_id'] = $formId;
            $feedbackData[$key]['field_id'] = $field['id'];
            $feedbackData[$key]['feedback_text'] = $field['feedback_text'];
            $feedbackData[$key]['created_at'] = now();
        }

        try {
            if (!empty($feedbackData)) {
                DB::table('feedbacks')->insert($feedbackData);
            }

            //Send form owner mail
            $sendMailUser = User::find($request->get('user_id'), ['email']);
            $mailText = Auth::user()->name . ', submitted a new feedback.';
            Mail::to($sendMailUser->email)->send(new NewFeedback($mailText));

            return $this->response(true, 'Submitted successfully.');
        } catch (\Exception) {
            return $this->response(false, 'Something went wrong!!', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
