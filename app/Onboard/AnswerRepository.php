<?php
/**
 * Created by PhpStorm.
 * User: kana
 * Date: 10/2/18
 * Time: 2:56 PM
 */

namespace App\Onboard;


use App\Models\Answer;

class AnswerRepository
{

    /**
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function getUserAssets($userId)
    {
        return Answer::query()
            ->where('type', 'assets')
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function getUserPrototype($userId)
    {
        return Answer::query()
            ->where('type', 'prototype')
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getServicesAnswers($userId)
    {
        return Answer::query()
            ->whereIn('type', array_pluck(config('onboard.services'), 'name'))
            ->where('user_id', $userId)
            ->get();
    }
}