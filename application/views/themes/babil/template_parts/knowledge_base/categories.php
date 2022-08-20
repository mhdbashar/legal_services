<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php if(isset($main_groups) && ($main_groups)>0){?>
    <?php foreach($main_groups as $category){?>





 
  		<div class="col-md-3">
               
        <div  class="text-center pt-3">

          <a href="<?php echo site_url('knowledge-base/category/'.$category->groupid); ?>" >  <img alt="category" src="<?php echo base_url()?>assets/images/book.png" width="150" height="150" ></a><br><span style="color:#093a64;font-weight: 900;font-size:20px;"><?php echo $category->name; ?> </span>
          </div>




                </div>










    <?php } ?>
<?php } ?>

