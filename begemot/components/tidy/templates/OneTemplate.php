<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 18.06.13
 * Time: 15:51
 * To change this template use File | Settings | File Templates.
 */
require_once('BaseTemplate.php');
class OneTemplate extends BaseTemplate
{

    protected $imageCount = 1;

    protected $config;

    public function __construct($config){
        $this->config = $config;
        if (isset($config['templateFile'])){
            $this->templateFile = $config['templateFile'];
        }
    }

    public function renderTemplate()
    {

        $image = $this->getImage();

        if (isset($image['title'])?$title=$image['title']:$title='');
        if (isset($image['alt'])?$alt=$image['alt']:$alt='');
        if ($this->templateFile === null){
            $html = '<div class="tidyTemplate"><img src="'.$image[$this->config['imageTag']].'" alt="'.$alt.'" title="'.$title.'" /></div>';
        } else{
            $html = $this->renderFileTemplate($this->templateFile,array('image'=>$image,'alt'=>$alt,'title'=>$title));
        }
        return $html;
    }

}