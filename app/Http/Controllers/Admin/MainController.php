<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboard(Request $request)
    {
        $query = User::with(['assets', 'questionAnswers', 'prototype'])
            ->where('type', 'customer')->latest();

        $status = $request->input('status');
        if($status == 'not_archived'){
            $query->where('is_archived', false);
        }elseif($status == 'archived'){
            $query->where('is_archived', true);
        }

        $users = $query->paginate(20);

        $questions = Question::query()->select('questions.*', 'question_sections.section_order', 'question_sections.name', 'question_sections.survey_id')->withSection()->with('survey')->get();

        $surveys = Survey::all();

        $surveyResults = $this->calculateUserProgress($users, $questions->groupBy('survey_id')->all());

        $services = Answer::query()
                        ->whereIn('user_id', $users->pluck('id')->all())
                        ->whereIn('type', array_pluck(config('onboard.services'), 'name'))
                        ->get();

        return view('admin.dashboard', compact('users', 'surveyResults', 'surveys', 'services'));
    }

    /**
     * @param $users
     * @param $surveys
     * @return array
     */
    public function calculateUserProgress($users, $surveys)
    {
        $surveyResults = [];
        foreach ($users as $user){
            $surveyResults[$user->id] = [];
            foreach ($surveys as $key => $survey){
                $completed = true;
                foreach($survey as $question){
                    $answer = $user->questionAnswers->where('question_id', $question->id)->first();
                    if(!is_null($answer)){
                        $completed = !$answer->is_finished ? false : $completed;
                    }else{
                        $completed = false;
                    }
                }
                $surveyResults[$user->id][$key] = $completed;
            }
        }

        return $surveyResults;
    }
}
