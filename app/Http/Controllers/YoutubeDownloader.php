<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use YoutubeDl\Options;
use YoutubeDl\YoutubeDl;

class YoutubeDownloader extends Controller
{
    public function youtubeGetAudio(Request $request,$url)
    {


        $yt = new YoutubeDl();
         $yt->setBinPath("C:\Users\Chisty\Downloads\yt-dlp.exe");
        $collection = $yt->download(
            Options::create()
                ->downloadPath('/')
                ->url('https://www.youtube.com/watch?v=oDAw7vW7H0c')
        );


        dd($collection);
        foreach ($collection->getVideos() as $video) {

            if ($video->getError() !== null) {
                echo "Error downloading video: {$video->getError()}.";
            } else {
                echo $video->getTitle(); // Will return Phonebloks
                // $video->getFile(); // \SplFileInfo instance of downloaded file
            }
        }
    }
}
