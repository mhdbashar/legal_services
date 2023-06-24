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
									<span class="edit-title"><?php echo _l('hr_document'); ?></span>
								</h4>


										<!-- general_info start -->
											<div class="row">
												<div class="row col-md-12">

													<div class="col-md-12 panel-padding">
														<table class="table border table-striped table-margintop">
															<tbody>
																<tr class="project-overview">
																	<td class="bold" width="30%"><?php echo _l('document_type'); ?></td>
																	<td><?php echo html_entity_decode($document->document_type) ; ?></td>
																</tr>
																<tr class="project-overview">
																	<td class="bold"><?php echo _l('document_title'); ?></td>
																	<td><?php echo html_entity_decode($document->document_title) ; ?></td>
																</tr>
																<tr class="project-overview">
																	<td class="bold"><?php echo _l('notification_email'); ?></td>
                                                                    <td><?php echo html_entity_decode($document->notification_email) ; ?></td>
                                                                </tr>
																<tr class="project-overview">
																	<td class="bold"><?php echo _l('date_expiry'); ?></td>
                                                                    <td><?php echo html_entity_decode($document->date_expiry) ; ?></td>
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
