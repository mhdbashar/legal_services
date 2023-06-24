<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12" id="training-add-edit-wrapper">
				<div class="row">
					<div class="col-md-12">
						<div class="panel_s">
							<div class="panel-body">

								<h4 class="modal-title pl-3">
									<span class="edit-title"><?php echo _l('hr_loan'); ?></span>
								</h4>


										<!-- general_info start -->
											<div class="row">
												<div class="row col-md-12">

													<div class="col-md-12 panel-padding">
														<table class="table border table-striped table-margintop">
															<tbody>
																<tr class="project-overview">
																	<td class="bold" width="30%"><?php echo _l('id'); ?></td>
																	<td><?php echo html_entity_decode($loan->id) ; ?></td>
																</tr>

																<tr class="project-overview">
																	<td class="bold"><?php echo _l('title'); ?></td>
                                                                    <td><?php echo html_entity_decode($loan->title) ; ?></td>
                                                                </tr>
																<tr class="project-overview">
																	<td class="bold"><?php echo _l('amount'); ?></td>
                                                                    <td><?php echo html_entity_decode($loan->amount) ; ?></td>
                                                                </tr>
                                                                <tr class="project-overview">
                                                                    <td class="bold"><?php echo _l('start_date'); ?></td>
                                                                    <td><?php echo html_entity_decode($loan->start_date) ; ?></td>
                                                                </tr>
                                                                <tr class="project-overview">
                                                                    <td class="bold"><?php echo _l('end_date'); ?></td>
                                                                    <td><?php echo html_entity_decode($loan->end_date) ; ?></td>
                                                                </tr>
                                                                <tr class="project-overview">
                                                                    <td class="bold"><?php echo _l('reason'); ?></td>
                                                                    <td><?php echo html_entity_decode($loan->reason) ; ?></td>
                                                                </tr>


															</tbody>
														</table>
													</div>

													<br>
												</div>
											</div>











						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>


</div>

</div>

</div>
<?php echo form_close(); ?>


</div>
<div id="contract_file_data"></div>
<?php init_tail(); ?>
</body>
</html>
