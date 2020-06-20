<?php defined('BASEPATH') or exit('No direct script access allowed');
$where = array('clientid'=>get_client_user_id());
foreach($project_statuses as $status){ ?>
	<div class="col-md-2 list-status projects-status">
		<a href="<?php echo site_url('clients/legals/'.$ServID.'/'.$status['id']); ?>" class="<?php if(isset($list_statuses) && in_array($status['id'], $list_statuses)){echo 'active';} ?>">
			<?php
            $where['status'] = $status['id'];
            if($ServID != 1){
                $where['service_id'] = $ServID;
            }
			?>
			<h3 class="bold">
                <?php
                $table = $ServID == 1 ? 'my_cases' : 'my_other_services';
                echo total_rows(db_prefix().$table,$where); ?>
            </h3>
			<span style="color:<?php echo $status['color']; ?>">
				<?php echo $status['name']; ?>
			</a>
		</div>
	<?php } ?>
