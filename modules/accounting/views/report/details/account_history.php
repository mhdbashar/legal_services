<div id="accordion">
  <div class="card">
    <?php // print_r( $filter);
     // exit();
      ?>
    <table class="tree">
      <tbody>
      <tr>
          <td colspan="7">
              <h3 class="text-center no-margin-top-20 no-margin-left-24"><?php echo get_option('companyname'); ?></h3>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
      </tr>
      <tr>
          <td colspan="7">
              <h5 class="text-center no-margin-top-20 no-margin-left-24"><?php echo _l('account') . ' : ' . $account_name ?></h5>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
      </tr>
        <tr>
          <td colspan="7">
            <h4 class="text-center no-margin-top-20 no-margin-left-24"><?php echo _l('account_history'); ?></h4>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="7">
            <p class="text-center no-margin-top-20 no-margin-left-24"><?php echo _d($data_report['from_date']) .' - '. _d($data_report['to_date']); ?></p>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="tr_header">
          <td class="text-bold"><?php echo _l('invoice_payments_table_date_heading'); ?></td>
          <td class="text-bold"><?php echo _l('transaction_type'); ?></td>
          <td class="text-bold"><?php echo _l('split'); ?></td>
          <td class="text-bold"><?php echo _l('description'); ?></td>
          <?php if($data_report['account_type'] == 3){ ?>
            <td class="total_amount text-bold"><?php echo _l('payment'); ?></td>
            <td class="total_amount text-bold"><?php echo _l('deposit'); ?></td>
          <?php }elseif($data_report['account_type'] == 7 || $data_report['account_type'] == 1){ ?>
            <td class="total_amount text-bold"><?php echo _l('charge'); ?></td>
            <td class="total_amount text-bold"><?php echo _l('payment'); ?></td>
          <?php }else{ ?>
            <td class="total_amount text-bold"><?php echo _l('decrease'); ?></td>
            <td class="total_amount text-bold"><?php echo _l('increase'); ?></td>
          <?php } ?>
          <td class="total_amount text-bold"><?php echo _l('balance'); ?></td>
        </tr>
        <?php
         $row_index = 0;
         ?>

              <?php foreach ($data_report['data'] as $val) {
              $row_index += 1;
              ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 ">
              <td>
              <?php echo _d($val['date']); ?> 
              </td>
              <td>

                  <a href=" <?php
                  if($val['rel_id']!=0)
                      if($val['rel_type']=='invoice')
                          echo admin_url('invoices/list_invoices/'. $val['rel_id']);
                  elseif($val['rel_type']=='journal_entry')
                        echo admin_url('accounting/journal_entry');
                  elseif($val['rel_type']=='deposit')
                      echo  '#';
                      elseif($val['rel_type']=='payment')
                        //  #invoice_payments_received
                           echo admin_url('invoices/list_invoices/'. $val['rel_id']);
                      elseif($val['rel_type']=='expense')
                          echo admin_url('expenses/list_expenses/'. $val['rel_id']);

                     else   echo '#';
                     ?>
                     ">
                      <?php echo html_entity_decode($val['type']); ?>
                  </a>

              </td>
              <td>
              <?php echo html_entity_decode($val['split']); ?> 
              </td>
              <td>
              <?php echo html_entity_decode($val['description']); ?> 
              </td>
              <td class="total_amount">

              <?php echo app_format_money($val['decrease'], $currency->name); ?> 
              </td>
              <td class="total_amount">
                  <?php echo app_format_money($val['increase'], $currency->name); ?>
              </td>
              <td class="total_amount">

                  <?php echo app_format_money($val['balance'], $currency->name); ?>
              </td>
            </tr>
          <?php }
            $row_index += 1;
            ?>
            </tbody>
        </table>
    </div>
</div>