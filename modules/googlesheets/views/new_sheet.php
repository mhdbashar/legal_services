<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                    <div class="panel-body">
                        
                    <h4 class="mbot15"><?php echo _l('My Google Sheets and Excel Files'); ?>
                <!-- <td><a class="btn btn-info" href="<?php echo site_url("googlesheets/logout/");?>"
                    onclick="return confirm('LOGOUT?');">LOGOUT</a></td> -->
                    <td><a class="btn btn-info" href="<?php echo site_url("googlesheets/");?>"
                    onclick="#">SAVE</a></td>
                  </h4>
                  <hr class="hr-panel-heading" />

                        <!-- <button type ="button" class = "btn btn-danger" value ="<td><a href="<?php echo site_url("googlesheets");?>> logout</button> -->

                        <iframe dir='rtl' src="https://docs.google.com/spreadsheets/d/<?=$spreadsheetId?>/edit?usp=sharing" style="height: 100vh; width: 100%;"></iframe>
                
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
</body>
</html>
