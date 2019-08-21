<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- Default switch -->

<div class="form-group">
<!--    <button type="button" class="flip-button"></button>-->
<!--    <input type="checkbox" name="hijri"  >Hijri-->
    <input type="checkbox"  id="hijri_check" data-toggle="toggle"  data-onstyle="primary" name="isHijriVal">
    <label for="hiri_check" style="margin-left: 5%">
        Hijri
    </label>
</div>
<hr />
<div class="form-group" id="adjust_div">
    <div class="form-group">
        <label  class="control-label clearfix" style="margin-bottom: 2%">
            Hijri adjustment
        </label>
        <div class="radio radio-primary radio-inline" style="margin-right: 2%">
            <input type="radio" id="zero" name="hijri_adjust" value="Y-m-d|%Y-%m-%d|hijri" checked>
            <label for="zero">
                0
            </label>
        </div>
        <div class="radio radio-primary radio-inline" style="margin-right: 2%">
            <input type="radio" id="one" name="hijri_adjust" value="Y-m-d|%Y-%m-%d|hijri|+1" >
            <label for="one">
                +1
            </label>
        </div>
        <div class="radio radio-primary radio-inline" style="margin-right: 2%">
            <input type="radio" id="minus" name="hijri_adjust" value="Y-m-d|%Y-%m-%d|hijri|-1" >
            <label for="minus">
                -1
            </label>
        </div>
    </div>
</div>
<hr />
<div class="form-group" id="tbl_div">
    <label  class="control-label clearfix">
        Hijri Pages
    </label>

        <div class="row clearfix">
            <div class="col-md-9 column">
                <table class="table table-bordered table-hover" id="tab_logic">
                    <thead>
                    <tr >
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            Link
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr id='addr0'>
<!--                        <td>-->
<!--                            1-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <input type="text" name='link0'  placeholder='Link' class="form-control"/>-->
<!--                        </td>-->

                    </tr>
<!--                    <tr id='addr1'></tr>-->
                    </tbody>
                </table>
            </div>
        </div>
        <a id="add_row" class="btn btn-default pull-left">Add Row</a><a id='delete_row' class="pull-right btn btn-default">Delete Row</a>

</div>


