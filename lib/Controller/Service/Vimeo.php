<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 1/10/14
 * Time: 9:22 AM
 * To change this template use File | Settings | File Templates.
 */
namespace rvadym\embed_video;
class Controller_Service_Vimeo extends Controller_EmbedVideo {

    public $service_type = 'vimeo.com';

    // http://stackoverflow.com/questions/17156298/get-id-video-vimeo-with-regexp-preg-match

    // http://developer.vimeo.com/player/embedding
    public $embed_html = '
        <iframe src="//player.vimeo.com/video/VIDEO_ID"
                width="WIDTH" height="HEIGHT" frameborder="0"
                webkitallowfullscreen mozallowfullscreen allowfullscreen
        ></iframe>';

    public $service_regexp = "/https?:\/\/(?:www\.)?vimeo\.com\/\d{8}/";

    function getVideoID($link) {
        return $this->getVimeoID($link);
    }

    function getEmbedHTML() {

    }

    private function getVimeoID( $url ) {
    	$regex = '~
    		# Match Vimeo link and embed code
    		(?:<iframe [^>]*src=")?         # If iframe match up to first quote of src
    		(?:                             # Group vimeo url
    				https?:\/\/             # Either http or https
    				(?:[\w]+\.)*            # Optional subdomains
    				vimeo\.com              # Match vimeo.com
    				(?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
    				\/                      # Slash before Id
    				([0-9]+)                # $1: VIDEO_ID is numeric
    				[^\s]*                  # Not a space
    		)                               # End group
    		"?                              # Match end quote if part of src
    		(?:[^>]*></iframe>)?            # Match the end of the iframe
    		(?:<p>.*</p>)?                  # Match any title information stuff
    		~ix';

    	preg_match( $regex, $url, $matches );

    	return $matches[1];
    }
}