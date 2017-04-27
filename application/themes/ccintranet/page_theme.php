<?php

namespace Application\Theme\ccintranet;
use Concrete\Core\Page\Theme\Theme;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTheme extends Theme {

    public function registerAssets() {
        //requireAsset = Loaded by C5
        $this->requireAsset('javascript', 'jquery-ui');
        $this->requireAsset('css', 'jquery-ui');
        //providesAsset = Loaded by theme
        $this->providesAsset('javascript', 'jquery');
        $this->providesAsset('javascript', 'bootstrap/*');
        $this->providesAsset('css', 'bootstrap/*');
        $this->providesAsset('css', 'font-awesome');
    }
    protected $pThemeGridFrameworkHandle = 'bootstrap3';
}
