<?php

$id = $project->id;
$service_slug = $this->legal->get_service_by_id($ServID)->row()->slug;

$this->db->where([
    'rel_type'=> $service_slug,
    'rel_id'=> $id
]);

$messages = $this->db->get(db_prefix(). 'saved_sms')->result();

?>

<table class="table dt-table scroll-responsive table-case-files" data-order-type="desc">
    <thead>
    <tr>
        <th><?php echo _l('sender'); ?></th>
        <th><?php echo _l('message'); ?></th>
        <th><?php echo _l('created_at'); ?></th>
        <th><?php echo _l('options'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($messages as $message){
        ?>
        <tr>

            <!--                                        <td data-order="--><?php //echo $message->msg; ?><!--">--><?php //echo $message->msg; ?><!--</td>-->


            <td data-order="<?php echo $message->sender; ?>"><?php echo $message->sender; ?></td>

            <td data-order="<?php echo $message->msg; ?>"><?php echo $message->msg; ?></td>


            <td data-order="<?php echo $message->created_at; ?>"><?php echo $message->created_at; ?></td>

            <td>
                <a href="<?php echo admin_url('zender/delete/' . $message->id); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
            </td>

        </tr>
    <?php } ?>
    </tbody>
</table>
<?php $this->load->view('messages/modal') ?>
