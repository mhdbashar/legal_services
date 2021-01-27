<?php
echo form_hidden('my_projects');
foreach($branches as $branch){
    $value = $branch['key'];
    echo form_hidden('project_branch_'.$branch['key'],$value);
    ?>

<?php } ?>