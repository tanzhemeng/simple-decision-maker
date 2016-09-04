<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display the form
     *
     * @return Response
     */
    public function showForm()
    {
        return view('qna.question');
    }

    /**
     * Validate and redirect
     *
     * @return Response
     */
    public function submitForm(Request $request)
    {
        $this->validate($request, [
            'question' => 'required',
            'choice.*' => 'required',
        ], [
            'choice.*' => 'This field is required',
        ]);

        $data = $request->all();
        unset($data['_token']);

        $response = ['url' => route('answer', $data)];

        return response()->json($response);
    }

    /**
     * Randomize and display the answer to the question
     *
     * @return Response
     */
    public function getAnswer(Request $request)
    {
        $question = $request->input('question');
        $choices = $request->input('choice');

        $total = count($choices);
        $selected = mt_rand(1, $total);

        return view('qna.answer', compact('question', 'choices', 'selected'));
    }
}