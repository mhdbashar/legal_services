<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="branch_credit_notes"><?php echo _l('report_branch'); ?></label>
            <select name="branch_credit_notes" class="selectpicker" multiple data-width="100%" data-none-selected-text="<?php echo _l('branch_report_all'); ?>">
                <?php foreach($branches as $branch){  ?>
                    <option value="<?php echo $branch['key']; ?>"><?php echo $branch['value'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>