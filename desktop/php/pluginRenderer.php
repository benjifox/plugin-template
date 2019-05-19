<?php

class pluginRenderer {
    const PLUGIN_ID  = 'template';
    const VERSION    = 'desktop';

    private $plugin          = NULL;
    private $eqLogics        = NULL;
    private $eqLogics_name   = '';
    private $templates_cache = NULL;
    
    public function __construct() {
        $this->plugin   = plugin::byId(pluginRenderer::PLUGIN_ID);
        $this->eqLogics = $eqLogics = eqLogic::byType($this->plugin->getId());
        $this->eqLogics_name = __('Mes templates', __FILE__);
        $this->eqLogic_label_name = __("Nom de l'équipement template", __FILE__);
        $this->templates_cache = array();
    }
    
    public function sendVarToJS() {
        sendVarToJS('eqType', $this->plugin->getId());
    }
    
    public function renderEqLogicThumbnail($eqLogic) {
        $replace_eqlogic = array(
            '#eqlogic_id#'         => $eqLogic->getId(),
            '#eqlogic_human_name#' => $eqLogic->getHumanName(true, true),
            '#eqlogic_opacity#'    => ($eqLogic->getIsEnable()) ? '' : 'disableCard',
            '#eqlogic_icon#'       => $this->plugin->getPathImgIcon(),
        );
        
        return template_replace($replace_eqlogic, $this->getTemplate('eqlogic.thumbnail.template'));
    }
    
    public function renderEqLogicsThumbnail() {
        $eqlogics_content = '';
        foreach ($this->eqLogics as $eqLogic) {
            $eqlogics_content .= $this->renderEqLogicThumbnail($eqLogic);
        }
        
        $replace_eqlogics = array(
            '#eqlogics_name#' => $this->eqLogics_name,
            '#eqlogics_content#' => $eqlogics_content,
        );
        
        return template_replace($replace_eqlogics, $this->getTemplate('eqlogics.thumbnail.template'));
    }
    
    public function renderEqLogicSettingsButtons() {
        $replace_buttons = array();
        
        return template_replace($replace_buttons, $this->getTemplate('eqlogic.settings.buttons.template'));
    }

    public function renderEqLogicNavTabs() {
        $replace_navbar = array();
        
        return template_replace($replace_navbar, $this->getTemplate('eqlogic.nav.tabs.template'));
    }
    
    public function renderEqLogicSettingsForm() {
        $replace_form = array(
            '#eqlogic_label_name#'            => $this->eqLogic_label_name,
            '#eqlogic_parentobj_options#'     => $this->renderEqLogicParentObjectsOptions(),
            '#eqlogic_categories_checkboxes#' => $this->renderEqLogicCategoriesCheckboxes(),
            '#eqlogic_settings_custom#'       => $this->renderEqLogicSettingsCustom(),
        );
        
        return template_replace($replace_form, $this->getTemplate('eqlogic.settings.form'));
    }
    
    public function renderEqLogicParentObjectsOptions() {
        $options = '<option value="">'.__('Aucun', __FILE__).'</option>';
        foreach (object::all() as $object) {
            $options .= '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
        }
        return $options;
    }
    
    public function renderEqLogicCategoriesCheckboxes() {
        $checkboxes = '';
        foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
            $checkboxes .= '<label class="checkbox-inline">';
            $checkboxes .= '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
            $checkboxes .= '</label>';
        }
        return $checkboxes;
    }
    
    public function renderEqLogicSettingsCustom() {
        $replace_custom = array();
        
        return template_replace($replace_custom, $this->getTemplate('eqlogic.settings.custom'));
    }
    
    public function renderEqLogicCommandTable() {
        $replace_commands = array();
        
        return template_replace($replace_custom, $this->getTemplate('eqlogic.commands.table'));
    }
    
    public function renderPluginSettingsCustom() {
        $replace_custom = array();
        
        return template_replace($replace_custom, $this->getTemplate('plugin.settings.custom'));
    }
    
    private function getTemplate($_filename) {
        if (!array_key_exists($_filename, $this->templates_cache)) {
            $path = dirname(__FILE__) . '/../../../' . pluginRenderer::PLUGIN_ID . '/' . pluginRenderer::VERSION . '/template/' . $_filename . '.html';
            $this->templates_cache[$_filename] = (file_exists($path)) ? file_get_contents($path) : '';
        }
        return $this->templates_cache[$_filename];
    }
}
