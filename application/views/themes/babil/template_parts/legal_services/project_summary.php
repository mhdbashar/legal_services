<?php defined('BASEPATH') or exit('No direct script access allowed');
$where = array('clientid'=>get_client_user_id());
if(!isset($ServID))
	$ServID = 1;
foreach($project_statuses as $status){ ?>
	<div class="col-md-2 list-status projects-status">
		<a href="<?php echo site_url('clients/legals/'.$ServID.'/'.$status['id']); ?>" class="<?php if(isset($list_statuses) && in_array($status['id'], $list_statuses)){echo 'active';} ?>">
			<?php
            if($ServID == 1){
                $where['status'] = $status['id'];
            }elseif ($ServID == 22){
                $where['status'] = $status['id'];
            }else{
                $where['status'] = $status['id'];
                $where['service_id'] = $ServID;
            }
			?>
			<h3 class="bold">
                <?php
                if($ServID == 1){
                    $table = 'my_cases';
                }elseif ($ServID == 22){
                    $table = 'my_disputes_cases';
                }else{
                    $table = 'my_other_services';
                }
                echo total_rows(db_prefix().$table,$where); ?>
            </h3>
			<span style="color:<?php echo $status['color']; ?>">
				<?php echo $status['name']; ?>
			</a>
		</div>
	<?php } ?>
