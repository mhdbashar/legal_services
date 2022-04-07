<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style type="text/css">fieldset, label { margin: 0; padding: 0; }.rating {   border: none;  float: left;}.rating > input { display: none; } .rating > label:before {   margin: 5px;  font-size: 1.25em;  font-family: FontAwesome;  display: inline-block;  content: "\f005";}.rating > .half:before {   content: "\f089";  position: absolute;}.rating > label {   color: #ddd;  float: right; }/***** CSS Magic to Highlight Stars on Hover *****/.rating > input:checked ~ label, /* show gold star when clicked */.rating:not(:checked) > label:hover, /* hover current star */.rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */.rating > input:checked + label:hover, /* hover current star when changing rating */.rating > input:checked ~ label:hover,.rating > label:hover ~ input:checked ~ label, /* lighten current selection */.rating > input:checked ~ label:hover ~ label { color: #FFED85;  }#rating_box{    display: inline-block;margin-left: 49px;}
.jquery-comments ul.main li.comment.edit > .comment-wrapper > *:not(.commenting-field, .rating) {
    display: none !important;
}
#comment-list .rating > input:checked ~ label, .rating:not(:checked) > label:hover, .rating:not(:checked) > label:hover ~ label {
    /* color: #FFD700; */
}
.rating{
  display: block !important;
}
@media print {
	#mindmap-comments, #membersContent, .colorHolder{
	    display:none;
	}
	#map  {
		display: block;
	}
}
</style>
<link rel="stylesheet" type="text/css" id="jquery-comments-css" href="<?php echo base_url();?>/assets/plugins/jquery-comments/css/jquery-comments.css">
<div id="wrapper">
    <div class="content">
        <div class="row">

            <?php
            if(isset($mindmap)){
                echo form_hidden('is_edit','true');
            }
            ?>

            <?php echo render_input('staffid','', get_staff_user_id(), 'hidden'); ?>
            <?php $value = (isset($mindmap) ? $mindmap->mindmap_content : ''); ?>
            <textarea style="display: none" id="mindmap_content" name="mindmap_content"><?php echo $value;?></textarea>
            <div class="col-lg-12" dir="ltr">

                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"><?php
                            echo (isset($mindmap) ? $mindmap->title : _l('mindmap'));?>
                            <?php
                            if (is_staff_logged_in() || is_admin() ) {
                                if(isset($mindmap->id)){
                                    ?>


                                <?php }
                                if(isset($mindmap->id)){
                                    ?>
                                    <div class="btn-group " style="float: right;margin-right:2px;">
                                        <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-effect waves-light waves-ripple" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                                    <?php echo  _l('actions') ?></font></font><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right width200 project-actions">
                                            <li>
                                                <a href="<?php echo admin_url('mindmap/mindmap_create/'.$mindmap->id);?>" type="button"><?php echo _l('edit')  ?></a>
                                            </li>
                                            <li>
                                                <a  id="delete-button" type="button" href="<?php echo admin_url('mindmap/delete/'.$mindmap->id); ?>"><?php echo _l('delete') ?></a>
                                            </li>
                                            <!-- <li>
                                               <a onclick="generatePDF()" href="javascript:void(0)">Download PDF</a>
                                            </li>
                                            <li>
                                               <a id="print"  href="javascript:void(0)">Print</a>
                                            </li> -->
                                            <li>
                                                <a  href="javascript:void(0)" onclick="send_email_modal();return false;"><?php echo _l('share_via_email') ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="new_discussion();return false;" ><?php echo _l('help')?></a>
                                            </li>

                                        </ul>
                                    </div>
                                <?php }
                            }
                            ?>
                            <span><a href="#" onclick="new_mindmap();return false;" class="btn btn-success" style="float: right;margin-right:2px;"><?php echo _l('properties') ?></a></span>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="row">
                            <div class="col-md-12">
                                <div id="map"></div>
                                <style>
                                    #map {
                                        height: 800px;
                                        width: 100%;
                                    }
                                </style>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="btn-bottom-toolbar text-right">
                    <button type="button" class="btn btn-info mindmap-btns"><?php echo _l('submit'); ?></button>
                </div>
            </div>

        </div>
        <div class="panel_s" dir="ltr">
               <div class="panel-body">
			    <div id="rating_box">

			   <fieldset class="rating">
			   <input type="radio" id="star5" name="rating" value="5" />
			   <label class = "full" for="star5" title="Awesome - 5 stars"></label>
			   <input type="radio" id="star4half" name="rating" value="4.5" />
			   <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
			   <input type="radio" id="star4" name="rating" value="4" />
			   <label class = "full" for="star4" title="Pretty good - 4 stars"></label>
			   <input type="radio" id="star3half" name="rating" value="3.5" />
			   <label class="half" for="star3half" title="Meh - 3.5 stars"></label>
			   <input type="radio" id="star3" name="rating" value="3" />
			   <label class = "full" for="star3" title="Meh - 3 stars"></label>
			   <input type="radio" id="star2half" name="rating" value="2.5" />
			   <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
			   <input type="radio" id="star2" name="rating" value="2" />
			   <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
			   <input type="radio" id="star1half" name="rating" value="1.5" />
			   <label class="half" for="star1half" title="Meh - 1.5 stars"></label>
			   <input type="radio" id="star1" name="rating" value="1" />
			   <label class = "full" for="star1" title="Sucks big time - 1 star"></label>
			   <input type="radio" id="starhalf" name="rating" value="0.5" />
			   <label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
			   </fieldset>
                <label style="float: left ;padding: 10px 0px;"><?php echo _l('rating')?> </label>
			   <label id="rating_value" style="padding: 10px;"></label>
			</div>
                  <div id="mindmap-comments"></div>
               </div>
               <input type="hidden" name="mindmap_id" value="<?php echo $mindmap->id;?>">
            </div>

        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<?php //$this->load->view('mindmap/mindmap_group'); ?>
  <!--- enter email modal ---------->
  <div class="modal fade in" id="email_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title">
            <span class="edit-title hide"><?php echo _l('add_email') ?></span>
            <span class="add-title"><?php echo _l('add_email') ?></span>
          </h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
                <!-- <div class="form-group" app-field-wrapper="from">
                <label for="from" class="control-label">
                <small class="req text-danger">* </small>from</label><input type="text" id="from" name="from" class="form-control" value="">
                </div> -->

           <?php
             $i = 0;
             $selected = '';
             foreach($staff as $member){
              if(isset($proposal)){
                if($proposal->assigned == $member['staffid']) {
                  $selected = $member['staffid'];
                }
              }
              $i++;
             }
             echo render_select('from',$staff,array('staffid',array('firstname','lastname')),'from',$selected);
             ?>

        <input type="hidden" id="from" name="from" class="form-control" value="<?php echo !empty(get_option('companyname')) ? get_option('companyname') : 'Perfex'; ?>">
                <div class="form-group" app-field-wrapper="subject">
                <label for="subject" class="control-label">
                <!-- <small class="req text-danger">* </small> -->
                <?php echo _l('subject') ?></label><input type="text" id="subject" name="subject" class="form-control" value="">
                </div>
                 <?php

             $selectede = '';
             foreach($contacts as $contact){

             }

              echo render_select('sent_to', $contacts, array('id','email','firstname,lastname'), 'ارسال الى',$selectede);
             ?>
                <div class="form-group" app-field-wrapper="content">

                <label for="content" class="control-label">
                <?php echo _l('content') ?></label>
                    <?php $userName = $GLOBALS['current_user']->firstname .' ' .$GLOBALS['current_user']->lastname; ?>
                <textarea  id="content" name="content" class="form-control" rows="4"><p><?php echo _l('mindmap_invite'); echo $userName; echo _l('mindmap_link');?></p><br data-mce-bogus="1"></p><p>
                </textarea>
                </div>

                <div class="modal-footer" style="text-align: center">
                <button type="button" class="btn btn-default" data-dismiss="modal" ><?php echo _l('close') ?></button>
                <button type="button" class="btn btn-info" data-loading-text="Please wait..." data-autocomplete="off" id="sendEmail"><?php echo _l('save') ?></button>
            </div>

            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
  </div>

  <div class="modal fade in" id="discussion" tabindex="-1" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title">
            <span class="edit-title hide"><?php echo _l('help') ?></span>
            <span class="add-title"><?php echo _l('help') ?></span>
          </h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">

              <p>1.<?php echo _l('help_mindmap')?></p>
                <p>2.<?php echo _l('help_mindmap2') ?></p></p>
                <p>3.<?php echo _l('help_mindmap3') ?></p>
                <p>4.<?php echo _l('help_mindmap4') ?></p>
                <!-- <p>5.  To add icon from <strong>fontawesome.com </strong>to the nodes, cut and past the icons into the icon field</p> -->
                <!-- <p>6. To Add a link in the node, add the url to the options of the node</p> -->
                <p>5.<?php echo _l('help_mindmap5') ?></p>
                <!-- <p>8. To print the mindmap click on “Action” button and print</p> -->
                <!-- <p>9. To download the mindmap click on “Action” button and download</p> -->
                <p>6.<?php echo _l('help_mindmap6') ?> </p>

              <br />
            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
  </div>


   <div class="modal fade mindmap-modal" id="mindmap_create" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'mindmap-form')) ;?>
            <?php echo render_input('staffid','', get_staff_user_id(), 'hidden'); ?>
        <div class="modal-content data">
            <div class="modal-header">
              <input type="hidden" name="mindmap_id" value="2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">
                    <span class="edit-title hide"><?php echo _l('mindmap'); ?></span>
                    <span class="add-title"><?php echo _l('edit') ?></span>
                </h4>
            </div>
                <div class="panel-body">
                       <hr>


                        <?php $value = (isset($mindmap) ? $mindmap->title : ''); ?>
                        <?php echo render_input('title',_l('name'),$value); ?>

                        <?php

                        $selected = (isset($mindmap) ? $mindmap->mindmap_group_id : '');
                        if(is_admin() || get_option('staff_members_create_inline_mindmap_group') == '1'){
                            echo render_select_with_input_group('mindmap_group_id',$mindmap_groups,array('id','name'),'mindmap_group',$selected,'<a href="#" onclick="new_group();return false;"><i class="fa fa-plus"></i></a>');
                        } else {
                            echo render_select('mindmap_group_id',$mindmap_groups,array('id','name'),'mindmap_group',$selected);
                        }
                        ?>

                        <?php $value = (isset($mindmap) ? $mindmap->description : ''); ?>
                        <?php echo render_textarea('description',_l('description'),$value,array('rows'=>4),array()); ?>
                        <?php //$external_url = (isset($mindmap) ? $mindmap->external_url : ''); ?>
                        <?php //echo render_input('external_url','External Url',$external_url); ?>
                    <div class="form-group">

                        <?php  foreach ($legal_services as $key=>$legal){?>

                        <?php }  ?>

                        <?php  echo render_select('rel_stype',$legal_services,array('slug','name'),'select_legal_services',$selected, ['onchange' => 'get_legal_services()'],[], 'services-wrapper','',true); ?>

                    </div>


                    <div class="form-group hide" id="div_rel_sid"  >
                        <label for="rel_sid" class="control-label"><?php echo _l('ServiceTitle'); ?></label>
                        <select class="form-control custom_select_arrow" id="rel_sid" name="rel_sid" placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                            <option selected disabled>

                            </option>

                        </select>
                    </div>

                    </div>
                    <div class="modal-footer" style="text-align: center">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close') ?></button>
                <button type="button" class="btn btn-info mindmap-btn" data-loading-text="Please wait..." data-autocomplete="off" data-form="#mindmap-form"><?php echo _l('save') ?></button>
            </div>
        </div>


       <?php echo form_close();?>
    </div>
</div>
<?php $this->load->view('mindmap/mindmap_group'); ?>
<?php init_tail(); ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
<script type="text/javascript">
  function new_mindmap(){
    $('#mindmap_create').modal('show');
}
 $("button.mindmap-btn").on('click', function (e) {
    if($('#title').val() == '' || $('#mindmap_group_id').val() == '' || $('#description').val() == ''){
        validate_mindmap_form();
    }else{
        $('#mindmap-form').submit();
    }

 })
function validate_mindmap_form(){
    appValidateForm($('#mindmap-form'), {
        title: 'required',
        mindmap_group_id: 'required',
        description : 'required',
    });
    $('#mindmap-form').submit();
}
function new_discussion() {
     $('#discussion').modal('show');
  }
$('#expand-button').click(function(){
  $('#top-panel').slideToggle( "slow" );
  //$('#expand-button').hide();
  $("html, body").animate({ scrollTop: 0 }, "slow");
  return false;
 });

 $('#close').click(function(){
  $('#top-panel').slideToggle( "slow" );
  $('#expand-button').show();
 });
$(function() {
    $(document).off('keypress.shortcuts keydown.shortcuts keyup.shortcuts');
    var d = MindElixir.new('new topic');
    if($('textarea#mindmap_content').val() != ''){
        d = JSON.parse($('textarea#mindmap_content').val());
    }
    var mind = new MindElixir({
        el: '#map',
        direction: 2,
        data: d,
        draggable: true,
        contextMenu: true,
        toolBar: true,
        nodeMenu: true,
        keypress: true,
    })
    mind.init();

    $("button.mindmap-btns").on('click', function (e) {
        $('textarea#mindmap_content').val(mind.getAllDataString());
          var count=0;
      var data = $('#mindmap-form').serializeArray().reduce(function(obj, item) {


          if(item.name != "external_url" && item.name != "project_id" && item.value=='')
          {
			  console.log(item);
			console.log(item.value);
            //validate_mindmap_form();
            count++;
          }
      }, {});

      if(count>0)
      {

        $('#top-panel').slideToggle( "slow" );
        //$('#expand-button').hide();
      }
         $.ajax({
        url: '<?php echo admin_url('mindmap/update_mindmap');?>',
        data: ({ 'id':mindmap_id,mindmap_content: $('textarea#mindmap_content').val(),'staffid':<?php echo get_staff_user_id()?> }),

        type: 'post',
        success: function(data) {
            //response = jQuery.parseJSON(data);
           window.location.reload(true);
        }
    });
    })
    //validate_mindmap_form();
});

</script>
<?php if(isset($mindmap->id)){ ?>
	<script>

		tinymce.init({
            selector: '#content',
            branding: false,
            directionality : 'rtl'
        });
</script>
<script>
  function update_rating(id){
    var updated_rating = $('input[name="rating_'+id+'"]:checked').val();
   console.log(updated_rating);
   $.ajax({
          type: 'post',
          url: admin_url + 'mindmap/update_discussion_comment_rating',
          data: {'id':id,'rating':updated_rating},
          success: function(comment) {
            console.log(updated_rating)
            $('#rt_val_'+id).text(updated_rating+'/5');
          },
          // error: error
        });
}
$(document).ready(function(){

    $('#print').click(function(){
   window.print();
 });
  $('#sendEmail').click(function(){

     var eml = $('#sent_to').val();
     var from = $('#from').val();
     var subject = $('#subject').val();
     var content = tinymce.get("content").getContent();
     if(eml == '' || from == '' || subject =='' || content == ''){
        $('.btn-info').attr('disabled', false);
        $('.btn-info').removeClass('disabled');
        $('.btn-info').text('Save');
        return false;
     }

    send_Email();
 });

});
function printDiv() {
            var divContents = document.getElementById("map").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<body > <h1>Div contents are <br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
        }
  function send_email_modal(){
      $('#email_modal').modal('show');

  }
 function send_Email(){
  var mindmap_id = $('input[name="mindmap_id"]').val();
    var eml = $('#sent_to').val();
     var from = $('#from').val();
     var subject = $('#subject').val();
     var content = tinymce.get("content").getContent();

          let data = {
            'mindmap_id':mindmap_id,'eml':eml,'subject':subject,'from':from,'content':content,
          };
          $.post( admin_url + 'mindmap/sendEmail', data);
          //console.log( data );
          $('#email_modal').modal('hide');
          $('#email').val('');
          $('.disabled').removeClass('disabled');


     }

      function generatePDF() {
          setTimeout( function pdfDivloaded (){
              let pdf = new jsPDF();
        let section=$('#map');
        let page= function() {
            pdf.save('mindmap.pdf');
            console.log('pdf');

        };
        pdf.addHTML(section,page);
          }, 3000);


      }


      var gantt_data = {};
   <?php if(isset($gantt_data)){ ?>
   gantt_data = <?php echo json_encode($gantt_data); ?>;
   <?php } ?>
   var mindmap_id = $('input[name="mindmap_id"]').val();
   var discussion_user_profile_image_url = $('input[name="discussion_user_profile_image_url"]').val();
   var current_user_is_admin = $('input[name="current_user_is_admin"]').val();
   var project_id = $('input[name="project_id"]').val(1);
   if(typeof(mindmap_id) != 'undefined'){
     discussion_comments('#mindmap-comments',mindmap_id,'regular');
   }
   $(function(){
    var project_progress_color = '<?php echo hooks()->apply_filters('admin_project_progress_color','#84c529'); ?>';
    var circle = $('.project-progress').circleProgress({fill: {
     gradient: [project_progress_color, project_progress_color]
   }}).on('circle-animation-progress', function(event, progress, stepValue) {
     $(this).find('strong.project-percent').html(parseInt(100 * stepValue) + '<i>%</i>');
   });
   });

   function discussion_comments(selector,mindmap_id,discussion_type){
     var defaults = _get_jquery_comments_default_config(<?php echo json_encode(get_project_discussions_language_array()); ?>);
     var options = {
      // https://github.com/Viima/jquery-comments/pull/169
      wysiwyg_editor: {
            opts: {
                enable: true,
                is_html: true,
                container_id: 'editor-container',
                comment_index: 0,
            },
            init: function (textarea, content) {
                var comment_index = textarea.data('comment_index');
                 var editorConfig = _simple_editor_config();
                 editorConfig.setup = function(ed) {
                      textarea.data('wysiwyg_editor', ed);

                      ed.on('change', function() {
                          var value = ed.getContent();
                          if (value !== ed._lastChange) {
                            ed._lastChange = value;
                            textarea.trigger('change');
                          }
                      });

                      ed.on('keyup', function() {
                        var value = ed.getContent();
                          if (value !== ed._lastChange) {
                            ed._lastChange = value;
                            textarea.trigger('change');
                          }
                      });

                      ed.on('Focus', function (e) {
                        textarea.trigger('click');
                      });

                      ed.on('init', function() {
                        if (content) ed.setContent(content);
                      })
                  }

                var editor = init_editor('#'+ this.get_container_id(comment_index), editorConfig)
            },
            get_container: function (textarea) {
                if (!textarea.data('comment_index')) {
                    textarea.data('comment_index', ++this.opts.comment_index);
                }
                return $('<div/>', {
                    'id': this.get_container_id(this.opts.comment_index)
                });
            },
            get_contents: function(editor) {
              console.log('edit');
               return editor.getContent();
            },
            on_post_comment: function(editor, evt) {
               editor.setContent('');
            },
            get_container_id: function(comment_index) {
              var container_id = this.opts.container_id;
              if (comment_index) container_id = container_id + "-" + comment_index;
              return container_id;
            }
        },
      currentUserIsAdmin:current_user_is_admin,
      getComments: function(success, error) {
        $.get(admin_url + 'mindmap/get_discussion_comments/'+mindmap_id+'/'+discussion_type,function(response){
          success(response);
        },'json');
      },
      postComment: function(commentJSON, success, error) {

		commentJSON.rating = $('input[name="rating"]:checked').val();
		console.log(commentJSON);
        $.ajax({
          type: 'post',
          url: admin_url + 'mindmap/add_discussion_comment/'+mindmap_id+'/'+discussion_type,
          data: commentJSON,
          success: function(comment) {
            comment = JSON.parse(comment);
            success(comment)
          },
          error: error
        });
      },
      putComment: function(commentJSON, success, error) {
		  commentJSON.updated_rating = $('input[name="rating_'+commentJSON.id+'"]:checked').val();
      console.log(commentJSON.updated_rating);
        $.ajax({
          type: 'post',
          url: admin_url + 'mindmap/update_discussion_comment',
          data: commentJSON,
          success: function(comment) {
            comment = JSON.parse(comment);
            success(comment)
          },
          error: error
        });
      },
      deleteComment: function(commentJSON, success, error) {
        $.ajax({
          type: 'post',
          url: admin_url + 'mindmap/delete_discussion_comment/'+commentJSON.id,
          success: success,
          error: error
        });
      },
      uploadAttachments: function(commentArray, success, error) {
        var responses = 0;
        var successfulUploads = [];
        var serverResponded = function() {
          responses++;
            // Check if all requests have finished
            if(responses == commentArray.length) {
                // Case: all failed
                if(successfulUploads.length == 0) {
                  error();
                // Case: some succeeded
              } else {
                successfulUploads = JSON.parse(successfulUploads);
                success(successfulUploads)
              }
            }
          }
          $(commentArray).each(function(index, commentJSON) {
            // Create form data
            var formData = new FormData();
            if(commentJSON.file.size && commentJSON.file.size > app.max_php_ini_upload_size_bytes){
             alert_float('danger',"<?php echo _l("file_exceeds_max_filesize"); ?>");
             serverResponded();
           } else {
            $(Object.keys(commentJSON)).each(function(index, key) {
              var value = commentJSON[key];
              if(value) formData.append(key, value);
            });

            if (typeof(csrfData) !== 'undefined') {
               formData.append(csrfData['token_name'], csrfData['hash']);
            }
            $.ajax({
              url: admin_url + 'mindmap/add_discussion_comment/'+mindmap_id+'/'+discussion_type,
              type: 'POST',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function(commentJSON) {
                successfulUploads.push(commentJSON);
                serverResponded();
              },
              error: function(data) {
               var error = JSON.parse(data.responseText);
               alert_float('danger',error.message);
               serverResponded();
             },
           });
          }
        });
        }
      }
      var settings = $.extend({}, defaults, options);
    $(selector).comments(settings);
   }
  function get_legal_services() {
      $('#div_rel_sid').removeClass('hide');
      $('#rel_sid').html('');
      slug = $('#rel_stype').val();
      $('#div_rel_sid').hide();
      $.ajax({
          type: 'POST',
          url: admin_url + 'mindmap/all_legal_services_without_client',
          data: {
              slug : slug
          },
          success: function(data) {
              response = JSON.parse(data);
              $('#rel_sid').append('<option value="" disabled selected>-- --</option>');
              $.each(response, function (key, value) {
                  $('#rel_sid').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');

              });
              $('#div_rel_sid').show();
          }
      });

  }



    </script>
<?php }
?>
<style type="text/css">
	.lt{width: 40px !important;}
    nmenu { border: 1px solid blue !important;}
</style>
</body>
</html>