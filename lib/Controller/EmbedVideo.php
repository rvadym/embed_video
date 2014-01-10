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
    private $width_tag    = 'WIDTH';
    private $height_tag   = 'HEIGHT';
    private $video_id_tag = 'VIDEO_ID';

    public $width;
    public $height;
    public $video_id;
    function checkLink($link) {
        return preg_match($this->service_regexp,$link);
    }

    abstract function getVideoID($link);
    abstract function getEmbedHTML();

}