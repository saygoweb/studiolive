<?php
use models\SettingsModel;

require_once(dirname(__FILE__) . '/../../../Config.php');

$settings = new SettingsModel(SettingsModel::DEFAULT_PROFILE);
$hasPreview = false;
if (HAS_PREVIEW) {
	$hasPreview = true;
	$previews = $settings->previews->data;
}

?>
<div id="st-wrapper">
<div id="st-controls" class="">
<tabset>
<div id="sceneSelect" class="right"><select ng-model="state.sceneId" ng-options="scene.id as scene.name for scene in scenes"></select></div>
<tab heading="Show Time">
	<div class="well">
	<div class="st-control" ng-repeat="action in sceneActions">
	{{action.name}}<div class="right"><button ng-click="stInClick(action.id)" class="btn btn-large">In</button><button ng-click="stOutClick(action.id)" class="btn btn-large">Out</button></div>
	</div>
	</div>
</tab>
<tab heading="Data">
	<div class="well">
	<button class="btn right" ng-click="saveScene()"><i class="icon-save"></i>Save</button>
	<table>
	<tbody ng:repeat="(aid, actionItem) in scene.dataSet">
	<tr><td colspan="2">
	<table width="100%">
	<tr><td>
	<h3>{{actionItem.name}}</h3>
	</td><td width="160px">
	<button ng-click="stInClick(aid)" class="btn preview">In</button>
	<button ng-click="stOutClick(aid)" class="btn preview">Out</button>
	<button ng-click="dataRefreshClick(aid, actionItem)" class="btn preview">Ref</button>
	</td></tr>
	</table>
	<tr ng:repeat="(did, data) in actionItem.data">
	<td style="min-width: 100px">{{data.name}}</td>
	<td><input ng-model="data.value" type="text" placeholder="value" /></td>
	</tr>
	</tbody>
	</table>
	</div>
</tab>
<tab heading="Actions">
	<div class="span3 well" style="display:inline-block;">
		<h3>Actions available</h3>
		<ul id="srcList" ui-sortable="sortOptions" class="actionList" ng-model="showActions" style="min-height:10px;">
		<li class="ui-state-default" ng-repeat="item in showActions">{{item.name}}</li>
		</ul>
	</div>
	<div class="span3 well" style="display:inline-block;">
		<h3>Actions in scene</h3>
		<ul id="destList" ui-sortable="sortOptions" class="actionList" ng-model="sceneActions" style="min-height:10px;">
		<li class="ui-state-default" ng-repeat="item in sceneActions">{{item.name}}</li>
		</ul>
	</div>
</tab>
</tabset>
</div>
</div>
<?php if ($hasPreview):?>
<div id="previews" class="right">
<p>Previews</p>
<?php for ($i = 0, $c = count($previews); $i < $c; $i++): ?>
<div class="st-preview">
	<form class="control-bar form-inline">
		<button class="btn" ng-click="previewPlay(previews[<?php echo $i; ?>])"><i class="icon-play"></i></button>
		<button class="btn" ng-click="previewStop(previews[<?php echo $i; ?>])"><i class="icon-stop"></i></button>
		<input ng-model="previews[<?php echo $i; ?>].channel" type="number" min="0" max="100" placeholder="Channel #" ></input>
	</form>
	<embed type="application/x-vlc-plugin" name="preview0"
         autoplay="yes" loop="no" height="270" width="480"
         target="<?php echo $previews[$i]->urlRx; ?>" />
</div>
<?php endfor; ?>
</div>
<?php endif; ?>
