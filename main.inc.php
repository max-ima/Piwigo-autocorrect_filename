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
    isset($_FILES)
    and isset($_SERVER["HTTP_USER_AGENT"])
    and preg_match('/\((iPhone|iPad|iPod);/', $_SERVER['HTTP_USER_AGENT'], $matches)
    and !empty($_POST['name'])
    )
  {
    if (isset($_POST['method']) and 'pwg.images.addSimple' == $_POST['method'] and isset($_FILES['image']))
    {
      $_FILES['image']['name'] = stripslashes($_POST['name']).'.'.get_extension($_FILES['image']['name']);
    }
    elseif (isset($_GET['method']) and 'pwg.images.upload' == $_GET['method'] and isset($_FILES['file']))
    {
      // photo upload in the new generation iOS application
      if (strtolower(get_extension($_POST['name'])) != strtolower(get_extension($_FILES['file']['name'])))
      {
        $_POST['name'].= '.'.get_extension($_FILES['file']['name']);
      }
    }
    elseif (isset($_GET['method']) and 'pwg.images.setInfo' == $_GET['method'] and !empty($_POST['name']))
    {
      $_POST['file'] = $_POST['name'].'.'.get_extension($_POST['file']);
    }
  }
}
