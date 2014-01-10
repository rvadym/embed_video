<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 1/10/14
 * Time: 9:21 AM
 * To change this template use File | Settings | File Templates.
 */
namespace rvadym\embed_video;
abstract class Controller_EmbedVideo extends \AbstractController {

    // addon tags
    private $video_id_tag = 'VIDEO_ID';
    private $width_tag    = 'WIDTH';
    private $height_tag   = 'HEIGHT';

    function checkLink($link) {
        return preg_match($this->service_regexp,$link);
    }

    function getEmbedHTML($video_id,$width,$height) {
        $html = $this->embed_html;
        $html = str_replace($this->video_id_tag,$video_id,$html);
        $html = str_replace($this->width_tag,$width,$html);
        $html = str_replace($this->height_tag,$height,$html);
        return $html;
    }

    abstract function getVideoID($link);
    abstract function getThumbs($video_id);

}