<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Answer;
use App\Onboard\DirectoryHelper;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;


class AssetController extends Controller
{
    /**
     * @var DirectoryHelper
     */
    private $directoryHelper;

    /**
     * AssetController constructor.
     * @param DirectoryHelper $directoryHelper
     */
    public function __construct(DirectoryHelper $directoryHelper, NotificationRepository $notifications)
    {
        $this->directoryHelper = $directoryHelper;
        $this->notifications = $notifications;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadAssets(Request $request)
    {
        /** @var  $user */
        $user = Auth::user();
        $userName = $request->user()->slug;
        $projectName = $request->user()->project_name;

        $dir = $this->directoryHelper->getOrCreateUserAssetDirectory($userName);

        $admin_user = User::where('type', 'admin')->firstOrFail();

        if(empty($request->file('files')) and is_null($request->input('link'))){
            return redirect()->back()->with('errors', 'No asset or link');
        }

        $answer = Answer::query()->firstOrCreate([
            'user_id'    => Auth::id(),
            'type'       => 'assets',
        ]);

        /** @var UploadedFile $file */
        if (!empty($request->file('files'))){
            foreach ($request->file('files') as $file){
                $file->storeAs($dir['path'], $file->getClientOriginalName(), 'google');
            }

            $user->update([
                'assettype' => 'file'
            ]);

            $answer->update([
                'folder'     => $dir['path'],
                'is_reviewed'   => false,
                'is_complete'   => false,
                'feedback'      => ''
            ]);

            $this->notifications->create($admin_user, [
                'icon' => 'fa-tickets',
                'body' => $projectName . ' uploaded some assets!',
                'action_text' => 'See them on Google Drive',
                'action_url' => 'https://drive.google.com/drive/folders/' . $dir['path'],
            ]);
        }elseif(!empty($request->input('link'))){

            $user->update([
                'assettype' => 'link'
            ]);

            $answer->update([
                'value'      => $request->input('link')
            ]);

            $this->notifications->create($admin_user, [
                'icon' => 'fa-tickets',
                'body' => $projectName . ' sent a link to some assets!',
                'action_text' => 'See them',
                'action_url' => $request->input('link'),
            ]);
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadPrototype(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $userName = $request->user()->slug;
        $projectName = $request->user()->project_name;

        $dir = $this->directoryHelper->getOrCreateUserPrototypeDirectory($userName);

        $admin_user = User::where('type', 'admin')->firstOrFail();

        if(empty($request->file('files')) and is_null($request->input('link'))){
            return redirect()->back()->with('errors', 'No asset or link');
        }

        $user->update([
            'prototypetype' => 'file'
        ]);

        $answer = Answer::query()->firstOrCreate([
            'user_id'    => Auth::id(),
            'type'       => 'prototype',
        ]);

        /** @var UploadedFile $file */
        if (!empty($request->file('files'))){
            foreach ($request->file('files') as $file){
                $file->storeAs($dir['path'], $file->getClientOriginalName(), 'google');
            }

            $answer->update([
                'folder'        => $dir['path'],
                'is_reviewed'   => false,
                'is_complete'   => false,
                'feedback'      => '',
            ]);

            $this->notifications->create($admin_user, [
                'icon' => 'fa-tickets',
                'body' => $projectName . ' uploaded photos of their prototype!',
                'action_text' => 'See them on Google Drive',
                'action_url' => 'https://drive.google.com/drive/folders/' . $dir['path'],
            ]);
        }elseif(!empty($request->input('link'))){

            $user->update([
                'prototypetype' => 'link'
            ]);

            $answer->update([
                'value'      => $request->input('link')
            ]);

            $this->notifications->create($admin_user, [
                'icon' => 'fa-tickets',
                'body' => $projectName . ' sent a link to some prototypes!',
                'action_text' => 'See them',
                'action_url' => $request->input('link'),
            ]);
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postTracking(Request $request)
    {
        $this->validate($request,[
            'tracking_number' => 'required|min:10'
        ]);

        $answer = Answer::query()->where([
            'user_id'    => Auth::id(),
            'type'       => 'prototype',
        ])->first();

        $answer->update([
            'tracking_number'   => $request->input('tracking_number'),
        ]);

        return redirect()->back();
    }


}
