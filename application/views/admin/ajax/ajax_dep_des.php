<?php $deps=$this->db->get_where("departments",array("comp_id"=>$cid))->result();
//print_r($deps);exit;
foreach($deps as $dep){?>
<p class="text-danger" style="margin-bottom:5px;"><?php echo $dep->dep_name;?></p><?php 
$desg=$this->db->get_where("designations",array("dep_id"=>$dep->dep_id))->result();
foreach($desg as $des){?>
<div class="fancy-checkbox" style="margin-bottom:5px;">
    <label><input type="checkbox" name="des[]" value="<?php echo $des->des_id;?>"><span><?php echo $des->des_name;?></span></label>
</div>
<?php }?><?php }?>