<?php
/**
 * Created by PhpStorm.
 * User: ktnan
 * Date: 7/11/2018
 * Time: 11:09 PM
 */

namespace App\Onboard;


use App\Models\Question;
use App\Models\QuestionSection;

class QuestionRepository
{

    /**
     * @param $user
     * @return mixed
     */
    public function getSurveysWithProgress($user)
    {
        $surveys = Question::query()
            ->orderBy('section_order', 'ASC')
            ->orderBy('question_order', 'ASC')
            ->withSection()
            ->select('questions.*', 'question_sections.section_order', 'question_sections.name', 'question_sections.survey_id')
            ->with(['user_answer' => function ($q) use ($user){
                $q->where('user_id', $user->id);
            }, 'survey'])
            ->get()
            ->groupBy('survey_id');

        return $surveys;
    }

    public function getSurveyWithProgress($user, $survey)
    {
        $questions = Question::query()
            ->orderBy('section_order', 'ASC')
            ->orderBy('question_order', 'ASC')
            ->withSection()
            ->select('questions.*', 'question_sections.section_order', 'question_sections.name', 'question_sections.survey_id')
            ->where('survey_id', $survey->id)
            ->with(['user_answer' => function ($q) use ($user){
                $q->where('user_id', $user->id);
            }, 'survey'])
            ->get();

        return $questions;
    }

    /**
     * @param $surveys
     * @return array
     */
    public function calculateSurveyProgress($surveys)
    {
        $surveyProgress = [];
        foreach ($surveys as $key => $survey){
            $surveyProgress[$key] = $this->calculateSingleSurveyProgress($survey);
        }

        return $surveyProgress;
    }

    /**
     * @param $surveyQuestions
     * @return array
     */
    public function calculateSingleSurveyProgress($surveyQuestions)
    {
        $completed = true;
        $reviewed = false;
        $total = count($surveyQuestions);
        $answeredCount = 0;
        $reviewedCount = 0;

        foreach ($surveyQuestions as $question){
            if($question->isFinished()){
                $answeredCount++;
            }else{
                $completed = false;
            }
            if($question->isReviewed()){
                $reviewedCount++;
            }
        }

        if($reviewedCount == $total){
            $reviewed = true;
        }
        $progress = round($answeredCount * 100/$total);

        $result = [
            'progress' => $progress,
            'is_completed' => $completed,
            'is_reviewed' => $reviewed,
        ];

        return $result;
    }


    public function getSurvey($id)
    {
        // $sections = QuestionSection::query()
        //     ->orderBy('section_order', 'ASC')
        //     ->orderBy('question_order', 'ASC')
        //     ->withSection()
        //     ->select('questions.*', 'question_sections.section_order', 'question_sections.name', 'question_sections.survey_id')
        //     ->where('survey_id', $id)
        //     ->get();

        $allSections = QuestionSection::orderBy('section_order', 'ASC')
                        ->where('survey_id', $id)
                        ->with(array('questions' => function($query) {
                            $query->orderBy('question_order', 'ASC');
                        }))

                        ->get();

        return $allSections;
    }

}