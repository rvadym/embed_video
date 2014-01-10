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
        $this->services['youtube.com'] = $this->add('rvadym\embed_video\Controller_Service_Youtube');
        $this->services['vimeo.com']   = $this->add('rvadym\embed_video\Controller_Service_Vimeo');
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

    function getThumbs($video_id,$video_service_type=null) {
        if (!$video_id) throw $this->exception('What is video id?');
        if (!$this->video_service && !$video_service_type) {
            throw $this->exception('Not clear what video service should be used.');
        } else if (!$this->video_service) {
            $video_service = $this->services[$video_service_type];
        } else {
            $video_service = $this->video_service;
        }
        return $video_service->getThumbs($video_id);
    }

    function getEmbedHTML($video_id,$video_service_type=null) {
        if (!$video_id) throw $this->exception('What is video id?');
        if (!$this->video_service && !$video_service_type) {
            throw $this->exception('Not clear what video service should be used.');
        } else if (!$this->video_service) {
            $video_service = $this->services[$video_service_type];
        } else {
            $video_service = $this->video_service;
        }
        return $video_service->getEmbedHTML($video_id,'500px','400px');
    }
}