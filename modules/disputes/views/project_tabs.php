<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="horizontal-scrollable-tabs">
  <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
  <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
  <div class="horizontal-tabs">
    <ul class="nav nav-tabs no-margin project-tabs nav-tabs-horizontal" role="tablist">
        <?php
        $visible_tabs = filter_project_visible_tabs($tabs, $project->settings->available_features);
/*
        $visible_tabs['sales']['children']['5'] = array(
                            'parent_slug' => 'sales',
                            'slug' => 'disputes_invoices',
                            'name' => _l('disputes_invoices'),
                            'view' => 'disputes/disputes_invoices',
                            'position' => '30',
                            'visible' => '1',
                            'icon' => '',
                            'href' => '#'
                        );
*/
        foreach($visible_tabs as $key => $tab){

            $dropdown = isset($tab['collapse']) ? true : false;
            ?>
            <li class="<?php if($key == 'project_overview' && !$this->input->get('group')){echo 'active ';} ?>project_tab_<?php echo $key; ?><?php if($dropdown){echo ' nav-tabs-submenu-parent';} ?>">
                <a
                data-group="<?php echo $key; ?>"
                role="tab"
                <?php if($dropdown){ ?>
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="true"
                    class="dropdown-toggle"
                    href="#"
                    id="dropdown_<?php echo $key; ?>"<?php } else { ?>
                    href="<?php echo admin_url('disputes/view/'.$project->id.'?group='.$key); ?>"
                    <?php } ?>>
                    <i class="<?php echo $tab['icon']; ?>" aria-hidden="true"></i>
                    <?php echo $tab['name']; ?>
                    <?php if (isset($tab['badge'], $tab['badge']['value']) && !empty($tab['badge'])) {?>
                        <span class="badge pull-right mleft5
                            <?=isset($tab['badge']['type']) &&  $tab['badge']['type'] != '' ? "bg-{$tab['badge']['type']}" : 'bg-info' ?>"
                            <?=(isset($tab['badge']['type']) &&  $tab['badge']['type'] == '') ||
                            isset($tab['badge']['color']) ? "style='background-color: {$tab['badge']['color']}'" : '' ?>>
                            <?= $tab['badge']['value'] ?>
                        </span>
                    <?php } ?>
                    <?php if($dropdown){ ?> <span class="caret"></span> <?php } ?>
                </a>
                <?php if($dropdown){ ?>
                    <?php if(!is_rtl()){ ?>
                        <div class="tabs-submenu-wrapper">
                        <?php } ?>
                        <ul class="dropdown-menu" aria-labelledby="dropdown_<?php echo $key; ?>">
                            <?php
                            foreach($tab['children'] as $d){
                                if($d['slug'] == 'project_invoices'){
                                    echo '<li class="nav-tabs-submenu-child"><a href="'.admin_url('disputes/view/'.$project->id.'?group=disputes_invoices').'" data-group="disputes_invoices">'.$d['name'];
                                }else {
                                    echo '<li class="nav-tabs-submenu-child"><a href="' . admin_url('projects/view/' . $project->id . '?group=' . $d['slug']) . '" data-group="' . $d['slug'] . '">' . $d['name'];
                                }
                                if (isset($d['badge'], $d['badge']['value']) && !empty($d['badge'])) {?>
                                    <span class="badge pull-right
                                    <?=isset($d['badge']['type']) &&  $d['badge']['type'] != '' ? "bg-{$d['badge']['type']}" : 'bg-info' ?>"
                                    <?=(isset($d['badge']['type']) &&  $d['badge']['type'] == '') ||
                                    isset($d['badge']['color']) ? "style='background-color: {$d['badge']['color']}'" : '' ?>>
                                    <?= $d['badge']['value'] ?>
                                </span>
                                <?php }

                                echo '</a></li>';
                            }
                            ?>
                        </ul>
                        <?php if(!is_rtl()){ ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</div>
</div>

