<?php
/**
 * Created by PhpStorm.
 * User: ktnan
 * Date: 7/8/2018
 * Time: 11:52 PM
 */

namespace App\Onboard;


use Illuminate\Support\Facades\Storage;

class DirectoryHelper
{

    /**
     * @param $path
     * @param $directoryName
     * @return mixed
     */
    protected function getDirectory($path, $directoryName)
    {
        $contents = collect(Storage::cloud()->listContents($path, false));

        $dir = $contents->where('type', '=', 'dir')
            ->where('filename', '=', $directoryName)
            ->first();

        return $dir;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getOrCreateUserDirectory($slug)
    {
        $dir = $this->getDirectory('/',$slug);

        if (!$dir) {
            Storage::cloud()->makeDirectory($slug);
            $dir = $this->getDirectory('/', $slug);
        }

        return $dir;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getOrCreateUserAssetDirectory($slug)
    {
        $userDirectory = $this->getOrCreateUserDirectory($slug);

        $assetDirectory = $this->getDirectory($userDirectory['path'] . "/", 'assets');

        if (!$assetDirectory) {
            Storage::cloud()->makeDirectory($userDirectory['path'] . "/". 'assets');
            $assetDirectory = $this->getDirectory($userDirectory['path'] . "/", 'assets');
        }

        return $assetDirectory;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getOrCreateUserPrototypeDirectory($slug)
    {
        $userDirectory = $this->getOrCreateUserDirectory($slug);

        $assetDirectory = $this->getDirectory($userDirectory['path'] . "/", 'prototype');

        if (!$assetDirectory) {
            Storage::cloud()->makeDirectory($userDirectory['path'] . "/". 'prototype');
            $assetDirectory = $this->getDirectory($userDirectory['path'] . "/", 'prototype');
        }

        return $assetDirectory;
    }

}