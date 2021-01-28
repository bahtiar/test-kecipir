<form action="" method="POST">
    <fieldset style="width: 800px;">
        <legend>1. Text Analizer  :</legend>
        <label for="data_string">String value</label>
        <input type="text" name="data_string" value="<?php echo isset($_POST['data_string']) ? $_POST['data_string'] : 'football vs soccer'; ?>" style="width: 750px;"  required />
        <button type="submit" name="submit" value="submit" >Save</button>
    </fieldset>
</form>

<?php
if($data):
?>
    <br>
    <fieldset style="width: 800px;">
    <legend>1. Result Text Analizer  :</legend>
    <div style="font-size: 12px; ">
<?php
    foreach($data as $v):
        echo $v['value'] . ': ' . $v['count'];
        echo  ': sebelum : ' . $v['before'];
        echo ' setelah : ' . $v['after'];
        if($v['distance'] != ''):
            echo ' jarak maksimum ' . $v['distance'];
        endif;
        echo '<br>';
    endforeach;
?>
</div>
    </fieldset><hr>
<?php
endif;
?>