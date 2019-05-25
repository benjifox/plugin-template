<?php

require_once __DIR__  . '/pluginRenderer.php';

class pluginRendererImpl extends pluginRenderer {
    const PLUGIN_ID = 'template';
    
    public function getPluginId() {
        return pluginRendererImpl::PLUGIN_ID;
    }
    
    public function getEqLogicsLabel() {
        return __("Mes équipements", __FILE__);
    }
    
    public function getEqLogicNameLabel() {
        return __("Nom de l'équipement", __FILE__);
    }
}

