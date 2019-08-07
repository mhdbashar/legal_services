   <?php
   $pinned_oservices = get_user_pinned_oservices();
   if(count($pinned_oservices) > 0){ ?>
      <li class="pinned-separator"></li>
      <?php foreach($pinned_oservices as $oservice_pin){ ?>
         <li class="pinned_oservice">
            <a href="<?php echo admin_url('SOther/view/'.$oservice_pin['service_id'].'/'.$oservice_pin['id']); ?>" data-toggle="tooltip" data-title="<?php echo _l('pinned_oservice'); ?>"><?php echo $oservice_pin['name']; ?><br><small><?php echo $oservice_pin["company"]; ?></small></a>
            <div class="col-md-12">
               <div class="progress progress-bar-mini">
                  <div class="progress-bar no-percent-text not-dynamic" role="progressbar" data-percent="<?php echo $oservice_pin['progress']; ?>" style="width: <?php echo $oservice_pin['progress']; ?>%;">
                  </div>
               </div>
            </div>
         </li>
      <?php } ?>
      <?php } ?>
