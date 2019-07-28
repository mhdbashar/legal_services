
				<div class="col-md-9">
										<?php $this->load->view('modals/editstaff'); ?>
					<div class="bg-white border rounded" style="padding: 20px 5px">
						<div class="panel-heading">
	                        <div class="panel-title">
	                            <span style="font-size: 17px"><?php echo $info['firstname'] ?></span>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#basic" data-title="New Holiday" data-readonly="">
				                        Edit Staff Account
				                    </button>
                                </div>
	                        </div><hr>
	                    </div>
						<div class="row">
							<div class="col-md-12" style="font-size: 15px">

									<div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">First Name</b>' ?> : <?php echo $info['firstname'] ?>
						            </div>
						            <div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">Last Name</b>' ?> : <?php echo $info['lastname'] ?>
						            </div>
						            <div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">Phone Number</b>' ?> : <?php echo $info['phonenumber'] ?>
						            </div>
						            <div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">Email</b>' ?> : <?php echo $info['email'] ?>
						            </div>
						            <div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">Skype</b>' ?> : <?php echo $info['skype'] ?>
						            </div>
						            <div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">Facebook</b>' ?> : <?php echo $info['facebook'] ?>
						            </div>
						        <?php if (isset($info['main_salary'])){ ?>
						            <div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">Main Salary</b>' ?> : <?php echo $info['main_salary'] ?>
						            </div>
						        <?php } ?>
						        <?php if (isset($info['transportation_expenses'])){ ?>
						            <div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">Transportation Expenses</b>' ?> : <?php echo $info['transportation_expenses'] ?>
						            </div>
						        <?php } ?>
						        <?php if (isset($info['other_expenses'])){ ?>
						            <div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">Other Expenses</b>' ?> : <?php echo $info['other_expenses'] ?>
						            </div>
						        <?php } ?>
						        <?php if (isset($info['gender'])){ ?>
						            <div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">Gender</b>' ?> : <?php echo $info['gender'] ?>
						            </div>
						        <?php } ?>
						        <?php if (isset($info['job_title'])){ ?>
						            <div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">Job Title</b>' ?> : <?php echo $info['job_title'] ?>
						            </div>
						        <?php } ?>
						        <?php if (isset($info['created'])){ ?>
						            <div class="col-md-6">
						                <?php echo '<b style="font-size: 17px">created</b>' ?> : <?php echo $info['created'] ?>
						            </div>
						        <?php } ?>
							</div>
						</div>
					</div>
				</div>
			
