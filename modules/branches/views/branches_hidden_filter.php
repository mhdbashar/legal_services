<?php
echo form_hidden('my_projects');
foreach($branches as $branch){
    $value = $branch['key'];
    echo form_hidden('project_branch_'.$branch['key'],$value);
    ?>
    <div class="col-md-2 col-xs-6 border-right">
        <?php $where = ($data['_where'] == '' ? '' : $data['_where'].' AND ').'tblbranches_services.branch_id = '.$branch['key']; ?>
        <?php $where .= ($data['ServID'] == 1 ? '' : ' AND '.db_prefix().$data['TableService'].'.service_id = '.$data['ServID']);
        $where .= (' AND '.db_prefix().$data['TableService'].'.deleted = 0'); ?>
        <a href="#" onclick="dt_custom_view('project_branch_<?php echo $branch['key']; ?>','<?php echo $data['class']; ?>','project_branch_<?php echo $branch['key']; ?>',true); return false;">
            <h3 class="bold">
                <?php

                $CI->db->join(db_prefix().'branches_services', db_prefix().'branches_services.rel_id='.db_prefix().$data['TableService'].'.clientid AND '.db_prefix().'branches_services.rel_type="clients"', 'inner');
                if (is_array($where)) {
                    if (sizeof($where) > 0) {
                        $CI->db->where($where);
                    }
                } elseif (strlen($where) > 0) {
                    $CI->db->where($where);
                }

                echo $CI->db->count_all_results(db_prefix().$data['TableService']);
                ?>
            </h3>

            <?php echo $branch['value']; ?>
            </span>
        </a>
    </div>
<?php } ?>