<?php 
// Store the count for JavaScript
$rowCount = count($itrs);
 $admin = $this->db->get("admin")->row();
                                    foreach($itrs as $itr){?>
                                    <tr>
                                        <td><input type="checkbox"  name="itr[]" value="<?php echo $itr->emp_id;?>" class="rowCheckbox">
                                        <a href="#" id="<?php echo $itr->itr_id; ?>" title="Delete" class="btn btn-sm btn-danger itr_delete"><i class="bi bi-archive"></i></a>
                                    <button type="button" title="<?php echo $itr->emp_name.'|'.$itr->emp_code.'|'.$itr->itr_yr;?>" id="<?php echo $itr->emp_id.'-'.str_replace("-","_",$itr->itr_yr);?>" class="btn btn-sm btn-info load_itr_box" data-bs-toggle="modal" data-bs-target="#load_itr_box"><i class="las la-file-invoice"></i> View</button>
	
                                    </td>
                                        <td><?php echo $itr->emp_name;?></td>
                                        <td><?php echo $itr->emp_code;?></td>
                                        <td><?php echo $itr->emp_pan;?></td>
                                        <td><?php echo $itr->emp_gpf;?></td>
                                         <td>
                                            <?php 
                                            $this->db->order_by("dt_month2","asc");
                                            $mon=$this->db->get_where("emp_data",array("dt_sal_ddo"=>$this->session->userdata("userid"),"dt_fnyr"=>$yrr,"dt_emp_id"=>$itr->itr_emp))->row();
                                            echo $mon->dt_month;?></td><td><?php 
                                            $this->db->order_by("dt_month2","desc");
                                            $mon=$this->db->get_where("emp_data",array("dt_sal_ddo"=>$this->session->userdata("userid"),"dt_fnyr"=>$yrr,"dt_emp_id"=>$itr->itr_emp))->row();
                                            echo $mon->dt_month;?>
                                        </td>
                                        <td><?php 
       if($this->db->get_where("emp_history",array("emp_hddo2"=>$this->session->userdata("userid"),"emp_code"=>$itr->emp_code))->num_rows()>0){
                    $this->db->select_sum('dt_dues');
					$this->db->where("dt_emp_id",$itr->itr_emp); 
					$this->db->where("dt_fnyr",str_replace("-","_",$itr->itr_yr));  
                    $this->db->where("dt_type!=",'PayArear'); 
                    $this->db->where("dt_sal_ddo!=",$this->session->userdata("userid")); 
                    $this->db->where("dt_sal_ddo!=",""); 
					$lll=$this->db->get('emp_data')->row();
					//print_r($lll);
					$total_dues=$lll->dt_dues;                                         
                                        echo $total_dues;
                                        }else{
                                     
                    $this->db->select_sum('dt_dues');
					$this->db->where("dt_emp_id",$itr->itr_emp); 
					$this->db->where("dt_fnyr",str_replace("-","_",$itr->itr_yr));  
                    $this->db->where("dt_type!=",'PayArear'); 
                    $this->db->where("dt_sal_ddo",""); 
					$lll=$this->db->get('emp_data')->row();
					//print_r($lll);
					$total_dues=$lll->dt_dues;                                         
                                        echo $total_dues;     
                                        }?></td>
                                        <td><?php echo round($itr->sal_head-$total_dues);?></td>
                                        <td><?php echo round($itr->sal_head);?></td>
                                        <td><?php echo round($itr->less);?></td>
                                        <td><?php echo round($itr->netincome);?></td>
                                        <td><?php echo $itr->house_status;?></td>
                                        <td><?php echo round($itr->net_hincome);?></td>
                                        <td><?php echo round($itr->other_sources);?></td>
                                        <td><?php echo round($itr->gross_total);?></td>
                                        <td><?php echo round($itr->nps_80ccd2);?></td>
                                        <td><?php echo round($itr->agniveer_80cch2);?></td>
                                        <td><?php echo round($itr->taxable);?></td>
                                        <td><?php echo round($itr->totalTax);?></td>
                                        
                                        <td><?php echo round($itr->rebate87A);?></td>
                                        <td><?php echo $tot=round($itr->totalTax-$itr->rebate87A);?></td>
                                        <td><?php echo round($itr->surcharge);?></td>
                                        <td><?php echo $tot+round($itr->surcharge);?></td>
                                        <td><?php echo round($itr->cess);?></td>
                                        <td><?php echo $tot=$tot+round($itr->surcharge+$itr->cess);?></td>
                                        <td><?php echo round($itr->advanceTax);?></td>
                                        <td><?php echo $tot=$tot-round($itr->advanceTax);?></td>
                                        <td><?php echo round($itr->rebate_89);?></td>
                                        <td><?php echo $itr->paytype;?></td>
                                        <td><?php echo round($itr->finalTaxLiability);?></td>
                                    </tr>
                                    <?php }?>



                                  <script>
$(".load_itr_box").click(function(){



var id=$(this).attr('id');
var p=$(this).attr('title');
var m=p.split("|");
var d='<table class="table table-condensed table-bordered"><tr><th>Employee Name</th><th>'+m[0]+'</th></tr>';
 d+='<tr><th>Employee Code</th><th>'+m[1]+'</th></tr>';
d+='<tr><th>Tax Computation FY</th><th>'+m[2]+'</th></tr></table>';
$(".modal-title").html(d);



$.ajax({



 type: "POST",



 url: '<?php echo base_url();?>admin/ajax_load_tax',



 data: {id:id},



 success: function(response){



	$(".itr_box").html(response);



 }



 });



});


                                    </script>