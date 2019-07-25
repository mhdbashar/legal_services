
				<div class="col-md-9">
										<?php $this->load->view('modals/editstaff'); ?>
					<div class="table-responsive p-5 bg-white border" style="padding: 10px">
						<div class="panel-heading">
	                        <div class="panel-title">
	                            <strong><?php echo $info['firstname'] ?></strong>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#basic" data-title="New Holiday" data-readonly="">
				                        Edit Staff Account
				                    </button>
                                </div>
	                        </div><hr>
	                    </div>
						<div class="row">
							<div class="col-md-12" style="font-size: 17px">

									<div class="col-md-6">
						                <?php echo 'First Name' ?> : <?php echo $info['firstname'] ?>
						            </div>
						            <div class="col-md-6">
						                <?php echo 'Last Name' ?> : <?php echo $info['lastname'] ?>
						            </div>
						            <div class="col-md-6">
						                <?php echo 'Phone Number' ?> : <?php echo $info['phonenumber'] ?>
						            </div>
						            <div class="col-md-6">
						                <?php echo 'Email' ?> : <?php echo $info['email'] ?>
						            </div>
						        <?php if (isset($info['main_salary'])){ ?>
						            <div class="col-md-6">
						                <?php echo 'Main Salary' ?> : <?php echo $info['main_salary'] ?>
						            </div>
						        <?php } ?>
						        <?php if (isset($info['transportation_expenses'])){ ?>
						            <div class="col-md-6">
						                <?php echo 'Transportation Expenses' ?> : <?php echo $info['transportation_expenses'] ?>
						            </div>
						        <?php } ?>
						        <?php if (isset($info['other_expenses'])){ ?>
						            <div class="col-md-6">
						                <?php echo 'Other Expenses' ?> : <?php echo $info['other_expenses'] ?>
						            </div>
						        <?php } ?>
						        <?php if (isset($info['gender'])){ ?>
						            <div class="col-md-6">
						                <?php echo 'Gender' ?> : <?php echo $info['gender'] ?>
						            </div>
						        <?php } ?>
						        <?php if (isset($info['job_title'])){ ?>
						            <div class="col-md-6">
						                <?php echo 'Job Title' ?> : <?php echo $info['job_title'] ?>
						            </div>
						        <?php } ?>
						        <?php if (isset($info['created'])){ ?>
						            <div class="col-md-6">
						                <?php echo 'created' ?> : <?php echo $info['created'] ?>
						            </div>
						        <?php } ?>
							</div>
						</div>
					</div>
				</div>
			
