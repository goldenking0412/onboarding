<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionSection;
use App\Models\Survey;
use App\Models\Ticket;

use App\Onboard\DirectoryHelper;
use App\Onboard\QuestionRepository;

use App\Mail\AssetsMailable;
use App\Mail\PrototypeMailable;
use App\Mail\AdminMessageMailable;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;

class CustomerController extends Controller
{

    /**
     * @var DirectoryHelper
     */
    private $directoryHelper;
    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    /**
     * CustomerController constructor.
     * @param DirectoryHelper $directoryHelper
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        DirectoryHelper $directoryHelper,
        QuestionRepository $questionRepository,
        NotificationRepository $notifications
    )
    {
        $this->directoryHelper = $directoryHelper;
        $this->questionRepository = $questionRepository;
        $this->notifications = $notifications;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCustomerForm()
    {
        return view('admin.customers.add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCustomer(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'name'  => 'required',
            'project_name'  => 'required',
            'password'  => 'required|confirmed'
        ]);

        $user = User::query()->create([
           'email'  => $request->input('email'),
           'password'   => bcrypt($request->input('password')),
           'name'   => $request->input('name'),
           'project_name'   => $request->input('project_name'),
           'slug'   => str_slug($request->input('project_name')) . '__' . time(),
           'type'   => 'customer'
        ]);

        $this->directoryHelper->getOrCreateUserDirectory($user->slug);

        return redirect(url('admin/dashboard'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $surveys = $this->questionRepository->getSurveysWithProgress($user);

        $surveyProgress = $this->questionRepository->calculateSurveyProgress($surveys);

        $assets = Answer::query()->where('type', 'assets')->where('user_id', $user->id)->first();

        $prototype = Answer::query()->where('type', 'prototype')->where('user_id', $user->id)
                            ->first();

        $services = Answer::query()->whereIn('type', array_pluck(config('onboard.services'), 'name'))->where('user_id', $user->id)->get();

        $tickets = Ticket::with('lastComment')->whereUserId($user->id)->get();

        return view('admin.customers.show', compact('surveys', 'surveyProgress', 'user', 'assets', 'prototype', 'services', 'tickets'));
    }

    /**
     * @param User $user
     * @return string
     */
    public function archive(User $user)
    {
        $user->update([
            'is_archived' => true,
            'archived_at' => Carbon::now()
        ]);

        return redirect(route('admin.customer.show', $user->id));
    }
    /**
     * @param User $user
     * @param Survey $survey
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReviewSurvey(User $user, Survey $survey)
    {
        $questions = $this->questionRepository->getSurveyWithProgress($user, $survey);

        $progress = $this->questionRepository->calculateSingleSurveyProgress($questions);

        return view('admin.customers.review-survey', compact('user', 'questions', 'survey', 'progress'));

    }
    /**
     * @param User $user
     * @param Survey $survey
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function exportReviewSurvey(User $user, Survey $survey)
    {
        $questions = $this->questionRepository->getSurveyWithProgress($user, $survey);

        $progress = $this->questionRepository->calculateSingleSurveyProgress($questions);

        return view('admin.customers.export-survey', compact('user', 'questions', 'survey', 'progress'));

    }

    /**
     * @param Request $request
     * @param User $user
     * @param Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postReviewAnswer(Request $request, User $user, Answer $answer)
    {
        $data = [];
        $this->validate($request, [
            'answer'    => 'required',
            'is_complete' => 'required|in:Mark Complete,Mark Incomplete'
        ]);

        $data['is_reviewed'] = true;
        $data['value'] = $request->input('answer');
        $data['feedback'] = $request->input('feedback');
        $data['is_complete'] = $this->getIsCompleteValue($request);

        $answer->update($data);


        $answer_user = User::where('id', $answer->user_id)->firstOrFail();

        $question = Question::where('id', $answer->question_id)->firstOrFail();
        $question_section = QuestionSection::where('id', $question->question_section_id)->firstOrFail();
        $survey = $question_section->survey_id;

        if (!empty($data['feedback'])):
            $this->notifications->create($answer_user, [
                'icon' => 'fa-bolt',
                'body' => 'There\'s feedback on one of your survey answers',
                'action_text' => 'See the feedback',
                'action_url' => '/surveys/'. $survey .'/'. $answer->question_id .'/show',
            ]);
        endif;

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param User $user
     * @param Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAssetsReview(Request $request, User $user, Answer $answer)
    {
        $data = [];

        $this->validate($request, [
            'is_complete' => 'required|in:Mark Complete,Mark Incomplete'
        ]);

        $data['is_reviewed'] = true;
        $data['feedback']   = $request->input('feedback');
        $data['is_complete'] = $this->getIsCompleteValue($request);

        $answer->update($data);

        $this->notifications->create($user, [
            'icon' => 'fa-photo',
            'body' => 'Your assets have been reviewed',
            'action_text' => 'Go to Dashboard',
            'action_url' => '/home',
        ]);

        Mail::to($user)->send(new AssetsMailable($answer));

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEmptyAssetsReview(Request $request, User $user)
    {
        $answer = Answer::query()->firstOrCreate([
            'user_id'    => $user->id,
            'type'       => 'assets',
        ]);

        $this->validate($request, [
            'is_complete' => 'required|in:Mark Complete,Mark Incomplete'
        ]);

        $data['is_reviewed']    = true;
        $data['feedback']       = $request->input('feedback');
        $data['is_complete']    = $this->getIsCompleteValue($request);

        $user->update([
            'assettype' => 'link'
        ]);
        $answer->update($data);
        $answer->update([
            'value'      => ''
        ]);

        $this->notifications->create($user, [
            'icon' => 'fa-photo',
            'body' => 'Your assets have been reviewed',
            'action_text' => 'Go to Dashboard',
            'action_url' => '/home',
        ]);

        return redirect()->back();
    }


    /**
     * @param Request $request
     * @param User $user
     * @param Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPrototypeReview(Request $request, User $user, Answer $answer)
    {
        $data = [];

        $this->validate($request, [
            'is_complete' => 'required|in:Mark Complete,Mark Incomplete'
        ]);

        $data['is_reviewed']    = true;
        $data['feedback']       = $request->input('feedback');
        $data['is_complete']    = $this->getIsCompleteValue($request);

        $answer->update($data);

        $this->notifications->create($user, [
            'icon' => 'fa-diamond',
            'body' => 'Your prototype has been reviewed.',
            'action_text' => 'Go to Dashboard',
            'action_url' => '/home',
        ]);

        Mail::to($user)->send(new PrototypeMailable($answer));

        return redirect()->back();
    }

    public function postEmptyPrototypeReview(Request $request, User $user)
    {
        $answer = Answer::query()->firstOrCreate([
            'user_id'    => $user->id,
            'type'       => 'prototype',
        ]);

        $this->validate($request, [
            'is_complete' => 'required|in:Mark Complete,Mark Incomplete'
        ]);

        $data['is_reviewed']    = true;
        $data['feedback']       = $request->input('feedback');
        $data['is_complete']    = $this->getIsCompleteValue($request);

        $user->update([
            'prototypetype' => 'link'
        ]);

        $answer->update($data);
        $answer->update([
            'value'      => ''
        ]);

        $this->notifications->create($user, [
            'icon' => 'fa-photo',
            'body' => 'Your prototype have been reviewed',
            'action_text' => 'Go to Dashboard',
            'action_url' => '/home',
        ]);

        return redirect()->back();
    }
    /**
     * @param Request $request
     * @param User $user
     * @param Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markReceived(Request $request, User $user, Answer $answer)
    {
        $answer->update([
           'is_received' => true
        ]);

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completePrototype(Request $request, User $user)
    {
        $answer = Answer::query()->firstOrCreate([
            'user_id'    => $user->id,
            'type'       => 'prototype',
        ]);

        $answer->is_reviewed = true;
        $answer->is_complete = true;
        $answer->is_received = true;
        $answer->value       = '';
        $answer->tracking_number = 'fake_tracking_number' . str_random();

        $answer->save();
        return redirect()->back();
    }


    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function serviceConnected(Request $request, User $user)
    {

        $this->validate($request, [
            'service' => 'in:' . implode(',', array_pluck(config('onboard.services'), 'name')),
            'is_complete' => 'required|in:Mark Correct,Mark Incorrect'
        ]);

        $answer = Answer::query()->where('type', $request->input('service'))
                                ->where('user_id', $user->id)
                                ->first();

        if(is_null($answer)){
            throw new \Exception('There is no answer.');
        }
        $isComplete = $this->getIsCorrectValue($request);

        $answer->update([
            'is_complete'    => $isComplete,
            'is_reviewed'   => true,
        ]);

        return redirect()->back();
    }

    public function message(Request $request, User $user)
    {
        $user->update([
            'message' => request('message')
        ]);

        session()->flash('message', 'Message Sent.');

        Mail::to($user)->send(new AdminMessageMailable($request));

        return redirect()->back();
    }
    public function admin_notes(Request $request, User $user)
    {
        $user->update([
            'admin_notes' => request('admin_notes')
        ]);

        session()->flash('admin_notes', 'Noted!');

        return redirect()->back();
    }


    /**
     * @param $request
     * @return bool
     */
    protected function getIsCompleteValue(Request $request)
    {
        if($request->input('is_complete') == 'Mark Complete'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $request
     * @return bool
     */
    protected function getIsCorrectValue(Request $request)
    {
        if($request->input('is_complete') == 'Mark Correct'){
            return true;
        }else{
            return false;
        }
    }

}
