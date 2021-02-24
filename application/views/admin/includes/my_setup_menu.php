<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="setup-menu-wrapper" class="animated <?php if($this->session->has_userdata('setup-menu-open')
    && $this->session->userdata('setup-menu-open') == true){echo 'display-block';} ?>">
    <ul class="nav metis-menu" id="setup-menu">
        <li>
            <a class="close-customizer"><i class="fa fa-close"></i></a>
            <span class="text-left bold customizer-heading"><?php echo _l('setting_bar_heading'); ?></span>
        </li>
        <?php
// Hrm menu start
        $branch = '';
        if($this->app_modules->is_active('hr') and has_permission('hr', '', 'view')){
            echo '<li class="menu-item-hr">';
            echo '<a href="#" aria-expanded="false"> '._l('hr').'<span class="fa arrow-ar"></span></a>';

            echo '<ul class="nav nav-second-level collapse" aria-expanded="false">
                        <li><a href="'.admin_url('hr').'" aria-expanded="false">'._l('dashboard').'</span></a>
                        </li>
                        <li><a href="#" aria-expanded="false">'._l('staff').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    <li><a href="'.admin_url('hr/general/staff').'">'._l('staff').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/general/expired_documents').'">'._l('expired_documents').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/contracts').'">'._l('staff_contract').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/insurances').'">'._l('insurrance').'</a>
                                    </li>
                                </ul>
                        </li>

                        <li><a href="#" aria-expanded="false">'._l('settings').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    <li><a href="'.admin_url('hr/setting').'">'._l('constants').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/setting/global_hr_setting').'">'._l('global_hr_setting').'</a>
                                    </li>
                                </ul>
                        </li>

                        <li><a href="#" aria-expanded="false">'._l('payroll').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    <li><a href="'.admin_url('hr/payroll').'">'._l('payroll').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/payroll/payment_history').'">'._l('payment_history').'</a>
                                    </li>
                                </ul>
                        </li>
';
            // <li><a href="#" aria-expanded="false">'._l('timesheet').'<span class="fa arrow-ar"></span></a>
            //         <ul class="nav nav-second-level collapse" aria-expanded="false">

            //             <li><a href="'.admin_url('hr/timesheet/attendance').'">'._l('attendance').'</a>
            //             </li>
            //             <li><a href="'.admin_url('hr/timesheet/calendar').'">'._l('calendar').'</a>
            //             </li>
            //             <li><a href="'.admin_url('hr/timesheet/date_wise_attendance').'">'._l('date_wise_attendance').'</a>
            //             </li>
            //             <li><a href="'.admin_url('hr/timesheet/leaves').'">'._l('leaves').'</a>
            //             </li>
            //             <li><a href="'.admin_url('hr/timesheet/overtime_requests').'">'._l('overtime_requests').'</a>
            //             </li>
            //             <li><a href="'.admin_url('hr/timesheet/office_shift').'">'._l('office_shift').'</a>
            //             </li>
            //         </ul>
            // </li>
            echo '
                        <li><a href="#" aria-expanded="false">'._l('performance').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                    
                                    <li><a href="'.admin_url('hr/performance/indicators').'">'._l('indicators').'</a>
                                    </li>
                                    <li><a href="'.admin_url('hr/performance/appraisals').'">'._l('appraisals').'</a>
                                    </li>
                                </ul>
                        </li>

                        <li><a href="#" aria-expanded="false">'._l('organization').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                '.$branch.'
                                <li><a href="'.admin_url('hr/organization/officail_documents').'">'._l('official_documents').'</a>
                                </li>
                                <li><a href="'.admin_url('departments').'">'._l('departments').'</a>
                                </li>';
            if(is_active_sub_department())
                echo '<li><a href="'.admin_url('hr/organization/sub_department').'">'._l('sub_department').'</a>
                                </li>';

            echo '<li><a href="'.admin_url('hr/organization/designation').'">'._l('designation').'</a>
                                </li>
                                </ul>
                        </li>

                        <li><a href="#" aria-expanded="false">'._l('core_hr').'<span class="fa arrow-ar"></span></a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false">
                                <li><a href="'.admin_url('hr/core_hr/awards').'">'._l('awards').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/terminations').'">'._l('terminations').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/warnings').'">'._l('warnings').'</a>
                                </li>';
            if(is_active_sub_department())
                echo    '<li><a href="'.admin_url('hr/core_hr/transfers').'">'._l('transfers').'</a>
                                </li>';

            echo    '<li><a href="'.admin_url('hr/core_hr/complaints').'">'._l('complaints').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/resignations').'">'._l('resignations').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/promotions').'">'._l('promotions').'</a>
                                </li>
                                <li><a href="'.admin_url('hr/core_hr/travels').'">'._l('travels').'</a>
                                </li>
                                </ul>
                        </li>
                </ul>';
            echo '</li>';
        }

        // Hrm menu end
        ?>
        <?php
        $totalSetupMenuItems = 0;
        foreach($setup_menu as $key => $item){
         if(isset($item['collapse']) && count($item['children']) === 0) {
           continue;
       }
       $totalSetupMenuItems++;
       ?>
       <li class="menu-item-<?php echo $item['slug']; ?>">
         <a href="<?php echo count($item['children']) > 0 ? '#' : $item['href']; ?>" aria-expanded="false">
             <i class="<?php echo $item['icon']; ?> menu-icon"></i>
             <span class="menu-text">
                 <?php echo _l($item['name'],'', false); ?>
             </span>
             <?php if(count($item['children']) > 0){ ?>
                 <span class="fa arrow"></span>
             <?php } ?>
         </a>
         <?php if(count($item['children']) > 0){ ?>
             <ul class="nav nav-second-level collapse" aria-expanded="false">
                <?php foreach($item['children'] as $submenu){
                   ?>
                   <li class="sub-menu-item-<?php echo $submenu['slug']; ?>"><a href="<?php echo $submenu['href']; ?>">
                       <?php if(!empty($submenu['icon'])){ ?>
                           <i class="<?php echo $submenu['icon']; ?> menu-icon"></i>
                       <?php } ?>
                       <span class="sub-menu-text">
                          <?php echo _l($submenu['name'],'',false); ?>
                      </span>
                  </a>
              </li>
          <?php } ?>
      </ul>
  <?php } ?>
</li>
<?php hooks()->do_action('after_render_single_setup_menu', $item); ?>
<?php } ?>

<?php if(get_option('show_help_on_setup_menu') == 1 && is_admin()){ $totalSetupMenuItems++; ?>
    <li>
        <!-- <a href="<?php //echo hooks()->apply_filters('help_menu_item_link','https://help.perfexcrm.com'); ?>" target="_blank"> -->
        <a href="<?php echo hooks()->apply_filters('help_menu_item_link','##'); ?>" target="_blank">
            <?php echo hooks()->apply_filters('help_menu_item_text',_l('setup_help')); ?>
        </a>
    </li>
<?php } ?>
</ul>
</div>
<?php $this->app->set_setup_menu_visibility($totalSetupMenuItems); ?>
