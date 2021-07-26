<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
<div class="content">
   <?php echo form_open($this->uri->uri_string(),array('id'=>'court-form')); ?>
   <div class="row">
      <div class="col-md-8 col-md-offset-2">
         <div class="panel_s">
            <div class="panel-body">
               <h4 class="no-margin">
                  <?php echo $title; ?>
               </h4>
               <hr class="hr-panel-heading" />
               <div class="clearfix"></div>
               <?php $value = (isset($court) ? $court->court_name : ''); ?>
               <?php echo render_input('court_name','name',$value); ?>               
            </div>
         </div>
      </div>
      <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
         <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
      </div>
   </div>
   <?php echo form_close(); ?>
</div>
</div>
<?php init_tail(); ?>
<script>
   $(function(){    
     _validate_form($('#court-form'),{court_name:'required'});
   });
</script>
</body>
</html>