<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php init_head();?>
<style>

    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #f0f8ff;
    border-color: #d1dbe5;
    color: #171818;
    cursor: not-allowed;
    line-height: 1.6;
    font-weight: 500;
}

</style>
<div id="wrapper">

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s project-top-panel panel-full">
                    <div class="panel-body _buttons">
                        <div class="row">
                            <div class="col-md-7 project-heading">



                            <h1>مشاهدة الرسالة</h1>

                           <div>
                           موضوع الرسالة
                         </div>

                           <p class="font-weight-bold">
                           <?php
if (isset($message_info->subject) && ($message_info->subject !== '')) {
    echo $message_info->subject;

}

?>
                        </p>

                                            <div class="form-group green-border-focus">
  <label for="exampleFormControlTextarea5">نص الرسالة</label>
  <textarea rows="5" cols="150" readonly class="form-control" id="exampleFormControlTextarea5" rows="3">
  <?php
if (isset($message_info->message) && ($message_info->message !== '')) {
    echo $message_info->message;

}

?>

</textarea>
</div>
                 <?php

if (isset($message_info->files) && ($message_info->files !== null)) {
    $path = get_upload_path_by_type('message');
    ?>
    <br>
                         <a target="_blank" href='<?php echo site_url(protected_file_url_by_path($path) . $message_info->id . '/' . $message_info->files) ?>'>





                                 <?php

    echo $message_info->files;

    ?>
                            </a>

                        <?php

}
?>





<h1>الردود على هذه الرسالة</h1>

                 <?php

if (isset($reply_messages)) {

    foreach ($reply_messages as $reply) {
        echo '<br><br>';
        $member = $model->GetSender($reply->from_user_id);
        echo $member->firstname . ' ' . $member->lastname;
        ?>
       <br><br>
        <div class="form-outline">
        <br>
  <textarea readonly class="form-control" id="textAreaExample1" rows="4"><?php echo $reply->message; ?></textarea>
 <br>
</div>

        <?php

        $path = get_upload_path_by_type('message');
        ?>
        <br>
                         <a target="_blank" href='<?php echo site_url(protected_file_url_by_path($path) . $reply->id . '/' . $reply->files) ?>'><?php echo $reply->files; ?></a>


    <?php

    }

}
?>

<div class="reply_message">


</div>






                     <div id="formmessage">

					<hr class="hr-panel-heading" />

					<form id="reply_message" action="" enctype="multipart/form-data">
                        <input type="hidden"  name="from_user_id" value="<?php echo get_staff_user_id() ?>">
                           <input type="hidden"  name="message_id" value="<?php echo $message_info->id; ?>">

                        <!-- for testing -->
                       	<?php echo render_textarea('description', _l('الرسالة'), '', array(), array(), '', ''); ?>
						<div class="form-group" >
                        <label for="profile_image" class="profile-image"><?php echo _l('attachment'); ?></label>
                        <input type="file" name="files" class="form-control" id="files">
                    </div>

						<button  type="submit" class="btn btn-info pull-right"><?php echo _l('رد على الرسالة'); ?></button>


                   </form>



                     </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
</div>



<?php init_tail();?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


<script type="text/javascript">
	$(document).ready(function(){

		$('#reply_message').submit(function(e){
		    e.preventDefault();
		    let html='';
		         $.ajax({
		              url: "<?php echo admin_url('messages/reply'); ?>",
		             type:"post",
		             data:new FormData(this),
		             dataType: 'json',
		             processData:false,
		             contentType:false,
		             cache:false,
		             async:false,
		              success: function(data){
                        html+=data.member.firstname;
html+=' ';
html+=data.member.lastname;
		                                     html += '<div class="form-group green-border-focus">';





   html +='<textarea rows="5" cols="150" readonly class="form-control tinymce" id="exampleFormControlTextarea5" rows="3">';
                   html += data.message.message;
               html+='</textarea>';
               html+='<a target="_blank" href="<?php echo site_url() ?>uploads/message/'+data.message.id+'/'+data.message.files+'">'+data.message.files+'</a>';


                 $('.reply_message').append(html);
		           }
		         });
		    });


	});

</script>

<script>
	$(function(){
        $("[name='description']").attr("required", true);
	
	});
</script>



</body>
</html>
