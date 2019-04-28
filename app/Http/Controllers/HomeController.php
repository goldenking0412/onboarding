<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Onboard\AnswerRepository;
use App\Onboard\QuestionRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;
    /**
     * @var AnswerRepository
     */
    private $answerRepository;


    /**
     * QuestionController constructor.
     * @param QuestionRepository $questionRepository
     * @param AnswerRepository $answerRepository
     */
    public function __construct(
        QuestionRepository $questionRepository,
        AnswerRepository $answerRepository
    ) {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show()
    {
        return view('home');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if($user->type == 'admin'){
            return redirect('admin/dashboard');
        }


        $surveys = $this->questionRepository->getSurveysWithProgress($user);

        $surveyProgress = $this->questionRepository->calculateSurveyProgress($surveys);

        $assets = $this->answerRepository->getUserAssets(Auth::id());

        $prototype = $this->answerRepository->getUserPrototype(Auth::id());

        $services = $this->answerRepository->getServicesAnswers(Auth::id());

        $totalSections = $leftSections = count($surveys) + 2 + count(config('onboard.services'));

        $leftSections = $this->calculateFinishedSteps($surveys, $surveyProgress, $assets, $prototype, $services);

        $completedSections = $totalSections - $leftSections;

        $progress = round((($totalSections - $leftSections) * 100 / $totalSections), 2);

        $i = 3;

        return view('home', compact('surveys', 'user', 'surveyProgress', 'assets', 'prototype', 'services', 'leftSections', 'totalSections', 'completedSections', 'progress', 'i'));
    }


    public function calculateFinishedSteps($surveys, $surveyProgress, $assets, $prototype, $services)
    {
        $leftSections = count($surveys) + 2 + count(config('onboard.services'));

        foreach ($surveyProgress as $survey){
            if($survey['progress'] == 100){
                $leftSections--;
            }
        }

        if(!is_null($assets)){
            if($assets->assetComplete()){
                $leftSections--;
            }
        }

        if(!is_null($prototype) and !is_null($prototype->tracking_number)){
            $leftSections--;
        }

        foreach(config('onboard.services') as $service){
            if(!is_null($services->where('type', $service['name'])->where('user_id', Auth::id())->first())){
                $leftSections--;
            }
        }

        return $leftSections;
    }

    /**
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitAssetURL(Request $request, $user)
    {
        Answer::query()->firstOrCreate([
           'user_id'    => $user,
           'type'       => 'assets',
           'value'      => 'asset_url',
            'folder'     => 'link',
            'is_reviewed'   => false,
            'is_complete'   => false,
            'feedback'      => ''
        ]);

        return back();
    }
}
