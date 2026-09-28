<?php //$cur=date("M-Y"); $hlist=$this->db->get_where("holidays",array("hmonth"=>$cur))->result();
$i=1;foreach($hlist as $h){?>
<tr><td><?php echo $i;?></td>
	<td><?php echo date("D d M",strtotime($h->hfrom_date)).'-'.date("D d M",strtotime($h->hto_date));?></td>
	<td><?php echo $h->htitle;?></td>
	<td><a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a></td></tr>
<?php $i++;}?>