<div class="tab-pane" id="{{contentBaseId}}-2">
			<div class="accsection">
				<div class="topwrap">
					<div class="row">
						<div class="container">
							<div class='col-md-3'>
								<h4><?= Yii::t('app', 'Start date and time');?></h4>
								<div class="form-group">
									<div class='input-group date' id='datetimepicker_start'>
										<input type='text' class="form-control" /> <span
											class="input-group-addon"> <span
											class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
							</div>
							<div class='col-md-3'>
								<h4><?= Yii::t('app', 'Start date and time');?></h4>
								<div class="form-group">
									<div class='input-group date' id='datetimepicker_end'>
										<input type='text' class="form-control" /> 
										<span class="input-group-addon"> 
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
							</div>
						</div>
						
						<div class="container">
						<h4><?= Yii::t('app', ' ');?></h4>
							<div class='col-md-3'>
								<div class="form-group">
									<label><input type="checkbox""><?= Yii::t('app', 'Remind me');?></label>
    							</div>
							</div>
	
							<div class='col-md-3'>
							<h4><?= Yii::t('app', ' ');?></h4>
								<div class="form-group">
									<select>
									  <option>1</option>
									  <option>2</option>
									  <option>3</option>
									  <option>4</option>
									  <option>5</option>
									</select>
									<?= Yii::t('app', 'Remind me');?>
								</div>
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<h4><?= Yii::t('app', 'Name');?></h4>
								<div class="form-group">
								<input type='text' class="form-control" />
								</div>
								
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<h4><?= Yii::t('app', 'Address');?></h4>
								<div class="form-group">
								<input type='text' class="form-control" />
								</div>
								
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<h4><?= Yii::t('app', 'Description');?></h4>
								<div class="form-group">
								<input type='text' class="form-control" />
								</div>
								
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<h4><?= Yii::t('app', 'Files');?></h4>
								<div class="form-group">
								<input type='file' class="form-control" />
								</div>
								
							</div>
						</div>
						
						<div class="container">
							<div class='col-md-6'>
								<h4><?= Yii::t('app', 'Calendar');?></h4>
								<div class="form-group">
								<input type='file' class="form-control" />
								</div>
								
							</div>
						</div>

						<div class="container">
							<div class='col-md-6'>
								<p>
								  <button class="btn btn-large btn-primary" type="button">Large button</button>
								  <button class="btn btn-large" type="button">Large button</button>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>