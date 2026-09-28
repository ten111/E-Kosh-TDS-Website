<?php foreach($conts as $c){?>
<li class="conts text-warning" id="<?php echo $c->cont_id;?>"><?php echo $c->cont_id.'-'.$c->c_company. '('.$c->c_contact_person.'-'.$c->c_contact_phone1;?>)</li>
<?php }?>
<script>
$(".conts").click(function(){
	var id=$(this).attr("id");
	$("#contract").val(id);
	$("#search_contract_result").html('');
});
</script>