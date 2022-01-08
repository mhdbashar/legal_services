<div id="accordion">
  <div class="card">
    <h3 class="text-center"><?php echo get_option('companyname'); ?></h3>
    <h4 class="text-center"><?php echo _l('accounts_receivable_ageing_summary'); ?></h4>
    <p class="text-center"><?php echo _d($data_report['to_date']); ?></p>
    <table class="tree">
      <thead>
        <tr class="tr_header">
          <th></th>
          <th class="th_total_width_auto"><?php echo _l('current'); ?></th>
          <th class="th_total_width_auto">1 - 30</th>
          <th class="th_total_width_auto">31 - 60</th>
          <th class="th_total_width_auto">61 - 90</th>
          <th class="th_total_width_auto">91 AND OVER</th>
          <th class="th_total_width_auto"><?php echo _l('total'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
         $row_index = 1; 
         $parent_index = 1; 
         $total = 0; 
         $total_current = 0; 
         $total_1_30 = 0; 
         $total_31_60 = 0; 
         $total_61_90 = 0; 
         $total_91_and_over = 0; 
         ?>
         <?php foreach ($data_report['data'] as $customer => $val) {
              $row_index += 1;
              $total_current += $val['current'];
              $total_1_30 += $val['1_30_days_past_due'];
              $total_31_60 += $val['31_60_days_past_due'];
              $total_61_90 += $val['61_90_days_past_due'];
              $total_91_and_over += $val['91_and_over'];
              $total += $val['total'];
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 ">
              <td>
              <?php echo get_company_name($customer); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['current'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['1_30_days_past_due'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['31_60_days_past_due'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['61_90_days_past_due'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['91_and_over'], $currency->name); ?> 
              </td>
              <td class="total_amount">
              <?php echo app_format_money($val['total'], $currency->name); ?> 
              </td>
            </tr>
          <?php }
            $row_index += 1;
           ?>
          
           <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 parent-node expanded tr_total">
            <td class="parent"><?php echo _l('total'); ?></td>
            <td class="total_amount"><?php echo app_format_money($total_current, $currency->name); ?></td>
            <td class="total_amount"><?php echo app_format_money($total_1_30, $currency->name); ?></td>
            <td class="total_amount"><?php echo app_format_money($total_31_60, $currency->name); ?></td>
            <td class="total_amount"><?php echo app_format_money($total_61_90, $currency->name); ?></td>
            <td class="total_amount"><?php echo app_format_money($total_91_and_over, $currency->name); ?></td>
            <td class="total_amount"><?php echo app_format_money($total, $currency->name); ?></td>
          </tr>
      </tbody>
    </table>
  </div>
</div>