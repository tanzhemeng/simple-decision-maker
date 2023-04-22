<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\DecisionMakerRequest;
use Illuminate\Support\Arr;

class DecisionMakerController extends Controller
{
    /**
     * Display the question form
     *
     * @return Response
     */
    public function showForm()
    {
        return Inertia::render('DecisionMaker/QuestionForm');
    }

    /**
     * Randomize an answer for the question
     *
     * @return Response
     */
    public function getAnswer(DecisionMakerRequest $request)
    {
        $question = $request->input('question');
        $answer = Arr::random($request->input('choices'));

        return response()->json([
            'question' => $question,
            'answer' => $answer,
        ]);
    }
}
