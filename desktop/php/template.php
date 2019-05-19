<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

require_once __DIR__  . '/pluginRenderer.php';
$renderer = new pluginRenderer();
$renderer->sendVarToJS();
?>

<div class="row row-overflow">
    <?php print  $renderer->renderEqLogicsThumbnail(); ?>
    <div class="col-xs-12 eqLogic" style="display: none;">
        <?php print $renderer->renderEqLogicSettingsButtons(); ?>
        <?php print $renderer->renderEqLogicNavTabs(); ?>
        <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
            <div role="tabpanel" class="tab-pane active" id="eqlogictab">
                <br/>
                <?php print $renderer->renderEqLogicSettingsForm(); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="commandtab">
                <?php print $renderer->renderEqLogicCommandTable(); ?>
            </div>
        </div>
    </div>
</div>

<?php include_file('desktop', pluginRenderer::PLUGIN_ID, 'js', pluginRenderer::PLUGIN_ID);?>
<?php include_file('core', 'plugin.template', 'js');?>
