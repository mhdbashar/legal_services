<li class="divider"></li>
<?php foreach($branches as $branch){ ?>

    <li class="active <?php if( $CI->input->get('branch_id') == $branch['key']){echo 'active';} ?>">
        <a href="#" data-cview="<?php echo 'project_branch_'.$branch['key']; ?>" onclick="dt_custom_view('project_branch_<?php echo $branch['key']; ?>','<?php echo $class; ?>','project_branch_<?php echo $branch['key']; ?>'); return false;">
            <?php echo $branch['value']; ?>
        </a>
    </li>
<?php } ?>