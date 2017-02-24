<?php

namespace Application\Theme\ccintranet;
use Concrete\Core\Page\Theme\Theme;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTheme extends Theme {

    public function registerAssets() {
        //requireAsset = Loaded by C5
        $this->requireAsset('javascript', 'jquery', 'jquery-ui', 'bootstrap3');
        $this->requireAsset('css', 'jquery-ui', 'bootstrap3');
        //providesAsset = Loaded by theme
        $this->providesAsset('javascript', 'jquery');
        $this->providesAsset('css', 'font-awesome');
    }
    protected $pThemeGridFrameworkHandle = 'bootstrap3';
}
