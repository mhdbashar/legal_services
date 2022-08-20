<?php defined('BASEPATH') or exit('No direct script access allowed');?>


<style>
  
.feedback {
  
  
  padding: 10px 20px;
  border-radius: 4px;
  border-color: #46b8da;
}

#mybutton {
  position: absolute;
  bottom: -11px;
  left: 3px;
}
  
</style>



<div class="col-md-12">
    <?php if(isset($childe_groups) && ($childe_groups)>0){?>
        <?php foreach($childe_groups as $category){?>
              
  
  
  
  		<div class="col-md-4 article-box">
               
        <div  class="text-center pt-3 ">

          <a href="<?php echo site_url('knowledge-base/category/'.$category->groupid); ?>" >  <img alt="category" src="<?php echo base_url()?>assets/images/book.png" width="150" height="150" ></a><br><span style="color:#093a64;font-weight: 900;font-size:13;"><?php  echo $category->name;  ?> </span>
          

 
          
          
          
          
           <small><?php echo $category->description; ?></small>
          
          
          
          
          
          


                </div>
  
  				</div>
  
  
  
        <?php } ?>
    <?php } ?>


       <?php foreach($articles as $category){?>
       
		
		
		
		
		
		
		 <?php echo "<center>" ?>
		 <?php echo "<h1>" ?>
       <?php echo $category['name']; ?>
       <?php echo "</h1>" ?>
		 <?php echo "</center>" ?>
		
		
		
		
		
		
		
		
		
		
        <ul class="list-unstyled articles_list">
            <?php foreach($category['articles'] as $article) { ?>
      
				
				
				
				
				
					<div class="col-md-4 article-box">
               
        <div  class="text-center pt-3 ">

          <a href="<?php echo site_url('knowledge-base/article/'.$article['articleid']); ?>" >  <img alt="category" src="<?php echo base_url()?>assets/images/book.png" width="150" height="150" ></a><br><span style="color:#093a64;font-weight: 900;font-size:13px;"><?php echo $article['subject']; ?> </span>
          </div>




                </div>
				
				
				
				
				
				
				
				
				
				
				
            <?php } ?>
        </ul>
 
    <?php } ?>
  
  
  		
               
        <div id="mybutton">
          
          
     <a style="background-color: #84c529;" class="btn btn-primary a-button feedback" href="javascript:history.go(-1)" title="Return to the previous page">رجوع للخلف</a>
          
          </div>
          

 
</div>


















