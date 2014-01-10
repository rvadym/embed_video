<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 1/10/14
 * Time: 9:23 AM
 * To change this template use File | Settings | File Templates.
 */
namespace rvadym\embed_video;
class Controller_EmbedVideoAdapter extends \AbstractController {

    private $services = array();
    public $video_service;

    function init() {
        parent::init();
        $this->services['youtube'] = $this->add('rvadym\embed_video\Controller_Service_Youtube');
        $this->services['vimeo']   = $this->add('rvadym\embed_video\Controller_Service_Vimeo');
    }

    function recognizeVideoService($link) {
        foreach ($this->services as $serv) {
            if ($serv->checkLink($link)) {
                $this->video_service = $serv;
                return $this->video_service;
            }
        }
        throw $this->exception('Video type not recognized or not supported','rvadym\\embed_video\\VideoTypeNotRecognized');
    }

    function getVideoID($link) {
        $this->recognizeVideoService($link);
        $video_id = $this->video_service->getVideoID($link);
        if (trim($video_id)=='')
            throw $this->exception('Video type not recognized or not supported','rvadym\\embed_video\\VideoTypeNotRecognized');
        return $video_id;
    }

    function getServiceType() {
        return $this->video_service->service_type;
    }
}