<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 1/10/14
 * Time: 9:36 AM
 * To change this template use File | Settings | File Templates.
 */
namespace rvadym\embed_video;
class Form_EmbedVideo extends \Form {
    public $ev_factory;
    function init() {
        parent::init();
        $this->ev_factory = $this->add('rvadym\\embed_video\\Controller_EmbedVideoFactory');
        $this->addFields();
        $this->addSubmitButton();
        $this->configure();
    }
    function addFields() {
        $this->addField('Line','video_link');
    }
    function addSubmitButton() {
        $this->addSubmit('GetVideo!');
        $this->onSubmit(array($this,'checkSubmittedForm'));
    }
    function checkSubmittedForm() {
        $js = array();

        $link = trim($this->get('video_link'));
        if ($link == '') $js[] = $this->js()->atk4_form('fieldError','video_link',$this->api->_('required'));

        try {
            $video_id = $this->ev_factory->getVideoID($link);
        } catch (Exception_VideoTypeNotRecognized $e) {
            $js[] = $this->js()->atk4_form('fieldError','video_link',$this->api->_('Link is not recognized'));
        }

        if (count($js)) {
            $this->js(null,$js)->execute(); echo 'ERROR'; exit;
        }

        $this->js()->univ()->successMessage($video_id)->execute();

    }
    function configure() {
        $this->addClass('atk-form-staked');
    }
}