<div class="panel_s">
     <div class="panel-body">
     <div class="clearfix"></div>
     <?php
     $data = array(
         _l('document_type'),
         _l('document_number'),
         _l('fullname'),
         _l('date_expiry'),
     );
     if (has_permission('expired_documents', '', 'delete'))
         $data[] = _l('control');
     render_datatable($data,'immigration');

     ?>
     </div>
 </div>