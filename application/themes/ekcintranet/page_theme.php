<?php

namespace Application\Theme\ekcintranet;
use Concrete\Core\Page\Theme\Theme;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTheme extends Theme {

    public function registerAssets() {
        //requireAsset = Loaded by C5
        $this->requireAsset('javascript', 'jquery', 'jquery-ui');
        $this->requireAsset('css', 'jquery-ui');
        //providesAsset = Loaded by theme
        $this->providesAsset('javascript', 'bootstrap3');
        $this->providesAsset('css', 'font-awesome', 'bootstrap3');
    }
    protected $pThemeGridFrameworkHandle = 'bootstrap3';
}

