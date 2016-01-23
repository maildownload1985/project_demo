<div class="file-preview" >
	<div class=" file-drop-zone" >
		<div class="file-preview-thumbnails">
			<div class="file-preview-frame-employess" id="preview-1453004722110-0" data-fileindex="0" ng-repeat="item in multipleDemo.selectedPeople">
				<img src="{{item.urlImage}}" class="file-preview-image" title="{{item.urlImage}}" alt="{{item.urlImage}}" style="width: auto; height: 160px;">
				<div class="file-thumbnail-footer">
					<div class="file-footer-caption" title="{{item.urlImage}}"><a href="javascript:;" class="ui-select-match-close select2-search-choice-close" ng-click="$selectMultiple.removeChoice($index)" tabindex="-1" style="width: auto; height: 160px;">s</a>Name: {{item.fullname}} </br>Department: {{item.department}}</div>
					<div class="file-actions">
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>