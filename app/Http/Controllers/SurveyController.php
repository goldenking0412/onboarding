<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use App\Models\QuestionSection;
use App\Onboard\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    /**
     * SurveyController constructor.
     * @param QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository) {
        $this->questionRepository = $questionRepository;
    }
    /**
     * @param Survey $survey
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nextQuestion(Survey $survey)
    {
        $user = Auth::user();

        $questions = $this->questionRepository->getSurveyWithProgress($user, $survey);

        $currentQuestion = $this->getCurrentQuestion($questions);

        $progress = $this->calculateProgress($questions);

        $sections = $questions->groupBy('name')->all();


        return view('surveys.next', compact('questions', 'currentQuestion', 'survey', 'sections', 'progress'));
    }

    /**
     * @param Request $request
     * @param Survey $survey
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function answerQuestion(Request $request, Survey $survey, Question $question)
    {
        // if (!empty($answer->value)){
            $answer = Answer::query()->firstOrCreate([
                'question_id'   => $question->id,
                'user_id'       => Auth::id(),
            ]);
            $answer->value = $request->input('value');
            $answer->is_reviewed = false;
            $answer->is_complete = false;
            $answer->save();
        // }
        

        return redirect(route('surveys.next', $survey->id));
    }


    /**
     * @param Survey $survey
     * @param Question $question
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showQuestion(Survey $survey, Question $question)
    {
        $user = Auth::user();

        $questions = $this->questionRepository->getSurveyWithProgress($user, $survey);

        $currentQuestion = $question;

        $currentQuestion->load(['user_answer' => function($q) use($user) {
            $q->where('user_id', $user->id);
        }]);

        $progress = $this->calculateProgress($questions);

        $sections = $questions->groupBy('name')->all();

        return view('surveys.next', compact('questions', 'currentQuestion', 'survey', 'sections', 'progress'));
    }

    /**
     * @param $questions
     * @return null
     */
    protected function getCurrentQuestion($questions)
    {
        $currentQuestion = null;

        foreach ($questions as $question){
            if(is_null($question->user_answer)){
                $currentQuestion = $question;
                break;
            }
            if(!$question->user_answer->is_finished){
                $currentQuestion = $question;
                break;
            }
        }

        return $currentQuestion;
    }

    protected function calculateProgress($questions)
    {
        $total = count($questions);
        $answered = 0;
        foreach ($questions as $question){
           if(isset($question->user_answer)){
               if($question->user_answer->is_finished){
                   $answered++;
               }
           }
        }

        return round($answered * 100/$total);
    }

    public function editSurvey($id)
    {
        $sections = $this->questionRepository->getSurvey($id);

        // dd($questions);

        return view('admin.edit-survey', compact('sections'));

    }
    public function editSurveyList($id)
    {
        $sections = $this->questionRepository->getSurvey($id);
        return $sections;
    }

    public function updateSurvey(Request $request)
    {
        foreach ($request->sections as $dragged_section) {
            $section = QuestionSection::where('id', $dragged_section['id'])->first();
            $section['section_order'] = $dragged_section['section_order'];
            $section->save();
            $index = 1;
            foreach ($dragged_section['questions'] as $dragged_question) {
                $question = Question::where('id', $dragged_question['id'])->first();
                // dd($dragged_question['question'] . '____' . $question['question_order'] .'---'. $dragged_question['question_order']);
                $question['question_order'] = $index++;
                $question['question_section_id'] = $dragged_question['question_section_id'];
                $question->save();  
            }
        }
        return response('Update Successful.', 200);

    }
}

