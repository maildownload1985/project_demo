<div class="tab-pane active" id="{{contentBaseId}}-1">
<div class="accsection">
				<div class="topwrap">
					<div class="row">
						<div class="container">
							<div class='col-md-3'>
										 <?= $form->field($event, 'start_datetime',
										 		[ 'template' => '
										 				{label}
										 				<div class="form-group">
										 					<div class="input-group date" id="datetimepicker_start">
										 						{input}
										 						<span class="input-group-addon"> 
										 							<span class="glyphicon glyphicon-calendar"></span>
																</span>
										 					</div>
										 				{error}{hint}
										 				</div>'
												]
										 	) ?>
										
							</div>
							<div class='col-md-3'>
										 <?= $form->field($event, 'end_datetime',
										 		[ 'template' => '
										 				{label}
										 				<div class="form-group">
										 					<div class="input-group date" id="datetimepicker_end">
										 						{input}
										 						<span class="input-group-addon"> 
										 							<span class="glyphicon glyphicon-calendar"></span>
																</span>
										 					</div>
										 				{error}{hint}
										 				</div>'
												]
										 ) ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-3'>
    							<?= $form->field($event, 'is_public')->checkbox() ?>
							</div>
	
							<div class='col-md-3'>
								<?php echo $form->field($event, 'name')->dropDownList(['a' => 'Item A', 'b' => 'Item B', 'c' => 'Item C'])->label(false); ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<?= $form->field($event, 'name')->textInput(['maxlength' => true]) ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<?= $form->field($event, 'address')->textInput(['maxlength' => true]) ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<?= $form->field($event, 'description')->textarea(['rows' => 6]) ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<h4><?= Yii::t('app', 'Files');?></h4>
								<div class="form-group">
								<input class="file" type="file" multiple data-preview-file-type="any" data-upload-url="#">
								</div>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<h4><?= Yii::t('app', 'Calendar');?></h4>
								<div class="form-group">
								<input class="file" type="file" multiple data-preview-file-type="any" data-upload-url="#">
								</div>
								
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
    							<?= $form->field($event, 'is_public')->checkbox() ?>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6 form-inline align_right'>
								<p>
								  <button class="btn btn-large btn-primary" type="button"><?= Yii::t('app', 'Submit');?></button>
								  <button class="btn btn-large" type="button"><?= Yii::t('app', 'Close');?></button>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>