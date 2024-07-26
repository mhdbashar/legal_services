<div id="accordion">
  <div class="card">
    <table class="tree">
      <tbody>
        <tr>
          <td colspan="2">
              <h3 class="text-center no-margin-top-20 no-margin-left-24"><?php echo get_option('companyname'); ?></h3>
          </td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2">
            <h4 class="text-center no-margin-top-20 no-margin-left-24"><?php echo _l('tax_liability_report'); ?></h4>
          </td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2">
            <p class="text-center no-margin-top-20 no-margin-left-24"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
          </td>
          <td></td>
        </tr>
        <tr class="tr_header">
          <td></td>
          <td class="th_total text-bold"><?php echo _l('amount'); ?></td>
        </tr>
        <?php
         $row_index = 0; 
         $parent_index = 0; 
         $total = 0; 
         ?>
<?php //*******  comment the old detailed version of report     ******** ?>
        <?php //foreach ($data_report['data'] as $val) {
           // $total = $row_index == 0 ? $total - $val['amount'] : $total = $total + $val['amount'];
           // $total = $total + $val['amount'];
            $row_index += 1;
            ?>
       <?php /*
        <tr class="treegrid-<?php //echo html_entity_decode($row_index); ?> treegrid-parent-10000 ">
              <td>
              <?php// echo html_entity_decode($val['name']); ?>
              </td>
              <td class="total_amount">
              <?php //echo app_format_money($val['amount'], $currency->name); ?>
              </td>
            </tr>
      */?>
          <?php //}
          $row_index += 1;
           ?>
        <?php
        //********* add the new version of report
        $total = $data_report['data_sales'] -$data_report['data_purchases'];
           ?>
      <?php //*****add the sales row *****?>
        <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 ">
            <td>
                <?php echo _l('tax_liability_report_sales'); ?>
            </td>
            <td class="total_amount">
                <?php echo app_format_money($data_report['data_sales'], $currency->name); ?>
            </td>
        </tr>
        <?php //*****add the purchases row *****?>
        <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 ">
            <td>
                <?php echo _l('tax_liability_report_purchases'); ?>
            </td>
            <td class="total_amount">
                <?php echo app_format_money($data_report['data_purchases'], $currency->name); ?>
            </td>
        </tr>
        <?php //*****  end *****?>
           <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> expanded tr_total treegrid-parent-10000">
            <td class="parent">
                <span style="margin-right: 24px!important; margin-top: -10px  ">
                  <?php echo _l('total'); ?>
                   </span>

            </td>
            <td class="total_amount"><?php echo app_format_money($total, $currency->name); ?> </td>
          </tr>
      </tbody>
    </table>
  </div>
</div>