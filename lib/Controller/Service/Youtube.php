<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 1/10/14
 * Time: 9:21 AM
 * To change this template use File | Settings | File Templates.
 */
namespace rvadym\embed_video;
class Controller_Service_Youtube extends Controller_EmbedVideo {

    public $service_type = 'youtube.com';

    // https://developers.google.com/youtube/iframe_api_reference
    public $embed_html = '
        <iframe id="player" type="text/html" width="WIDTH" height="HEIGHT"
          src="http://www.youtube.com/embed/VIDEO_ID?enablejsapi=1"
          frameborder="0"></iframe>';

    public $service_regexp = "/^http:\/\/(?:www\.)?(?:youtube.com|youtu.be)\/(?:watch\?(?=.*v=([\w\-]+))(?:\S+)?|([\w\-]+))$/";

    function getVideoID($link) {
        return $this->getYoutubeID($link);
    }

    function getThumbs($video_id) {
        return array(
            "http://img.youtube.com/vi/$video_id/0.jpg",
            "http://img.youtube.com/vi/$video_id/1.jpg",
            "http://img.youtube.com/vi/$video_id/2.jpg",
            "http://img.youtube.com/vi/$video_id/3.jpg",
        );
    }

    private function getYoutubeID($url) {
        $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
        preg_match($pattern, $url, $matches);
        return (isset($matches[1])) ? $matches[1] : false;
    }
}