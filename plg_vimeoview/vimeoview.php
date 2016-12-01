<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


class PlgContentVimeoView extends JPlugin
{
  protected $autoloadLanguage = true;
  
  protected function _insertVimeoCode(&$text)
  {
    $pattern = '/\{vimeoview\s+id=(\d+)\}/';
  
    while(preg_match($pattern, $text, $matches, PREG_OFFSET_CAPTURE))
    {    
      $tag = $matches[0][0];
      $tag_offset = $matches[0][1];
      $id = $matches[1][0];
    
      $replacement = sprintf('<iframe src="http://player.vimeo.com/video/%s" width="800" height="409" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>', $id);
      //$replacement = sprintf('id=%s', $id);

      $text = substr_replace($text, $replacement, $tag_offset, strlen($tag));
    }
  }
      
  public function onContentPrepare($context, &$row, &$params, $page = 0)
  {
    // Don't run this plugin when the content is being indexed
    if ($context == 'com_finder.indexer')
    {
      return true;
    }

    if (is_object($row))
    {
      $this->_insertVimeoCode($row->text);
    }
    else
    {
      $this->_insertVimeoCode($row);
    }

    return true;
  }    
}


?>
