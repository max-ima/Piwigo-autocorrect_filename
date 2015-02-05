<?php 
/*
Plugin Name: Autocorrect Filename
Version: auto
Description: Autocorrect filename of the photo on upload
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=
Author: plg
Author URI: http://le-gall.net/pierrick
*/

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

add_event_handler('init', 'autofilename_init');
function autofilename_init()
{
  if (
    isset($_FILES['image'])
    and isset($_SERVER["HTTP_USER_AGENT"])
    and preg_match('/\((iPhone|iPad|iPod);/', $_SERVER['HTTP_USER_AGENT'], $matches)
    and isset($_POST['method'])
    and 'pwg.images.addSimple' == $_POST['method']
    and !empty($_POST['name'])
    )
  {
    $_FILES['image']['name'] = stripslashes($_POST['name']).'.'.get_extension($_FILES['image']['name']);
  }
}
