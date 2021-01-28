<!-- <form action="" method="POST">
    <fieldset style="width: 800px;">
        <legend>2. Posisi ke-n digit :</legend>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="data_digit">Jumlah Digit</label>
                    <input type="number" class="form-control" name="data_digit" value="<?php echo isset($_POST['data_digit']) ? $_POST['data_digit'] : 100; ?>"  required />
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" name="submit" class="btn btn-primary" value="submit" >Send</button>
            </div>
        </div>
    </fieldset>
</form> -->

<?php
if($countNumber):
?>
    <br>
    <fieldset style="width: 800px;">
    <legend>2. Posisi ke-n digit :</legend>
    <div style="font-size: 14px; font: arial;">
<?php
    echo '<br><br>1.000.000         : ' . $countNumber[0];
    echo '<br><br>1.000.000.000     : ' . $countNumber[1];
    echo '<br><br>1.000.000.000.000 : ' . $countNumber[2];
?>
</div>
    </fieldset> 
<?php
endif;
?>