<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function showForm()
    {
        return view('qna.question');
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
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

        // dd($response);

        return response()->json($response);
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
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