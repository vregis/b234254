<?php $page_numbers = ceil($count/5);?>

<?php for($i=1;$i<=$page_numbers;$i++):?>
    <a style="display:inline" class="pagination-search <?php echo $i == $active?'active':''?>" data-id = '<?php echo $i?>'><?php echo $i?></a>
<?php endfor;?>
