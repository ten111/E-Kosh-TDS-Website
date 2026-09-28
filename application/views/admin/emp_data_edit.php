<form action="" method="post" id="editform">
<input type="hidden"  class="form-control" name="dt_id" value="<?php echo $edit->dt_id;?>"/>
<div class="row">

  <div class="form-group col-md-4"> 
                                <label for="email">Salary DDO</label>
  <input type="text" value="<?php if($edit->dt_sal_ddo_code!=''){echo $edit->dt_sal_ddo_code;}else{echo $this->session->userdata("ddo_num");}?>"  class="form-control" id="dt_sal_ddo" name="dt_sal_ddo_code"/>
  <input type="hidden" value="<?php echo $edit->dt_sal_ddo;?>"  id="ddoid" name="dt_sal_ddo"/>
  <small id="ddo_error"></small>

                              </div>
                              <div class="form-group col-md-4"> 
                                <label for="email">Bill No</label>
                                <input type="text"  class="form-control"  value="<?php echo $edit->dt_bill_no;?>" name="dt_bill_no"/>
                              </div>

                              <div class="form-group col-md-4"> 
                                <label for="email">BTR No</label>
                                <input type="text" class="form-control"  value="<?php echo $edit->dt_btr;?>" name="dt_btr"/>
                              </div>

</div>
<div class="row mt-2">
<div class="col-md-6">
  <h5 class="text-success">Dues</h5>
  <div class="form-group"> 
                                <label for="email">Basic</label>
                                <input type="text" required class="form-control input-class"  value="<?php echo $edit->dt_basic;?>" name="dt_basic"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">DA</label>
                                <input type="text" required class="form-control input-class"  value="<?php echo $edit->dt_da;?>" name="dt_da"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">House Allowance</label>
                                <input type="text" required class="form-control input-class"  value="<?php echo $edit->dt_house;?>" name="dt_house"/>
                              </div>


                              <div class="form-group"> 
                                <label for="email">CITY ALLOWANCE</label>
                                <input type="text" required class="form-control input-class"  value="<?php echo $edit->dt_city;?>" name="dt_city"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">WASHING ALLOWANCE	</label>
                                <input type="text" required class="form-control input-class"  value="<?php echo $edit->dt_wash;?>" name="dt_wash"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">MEDICAL ALLOWANCE</label>
                                <input type="text" required class="form-control input-class"  value="<?php echo $edit->dt_medical;?>" name="dt_medical"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">OTHER ALLOWANCE	</label>
                                <input type="text" required class="form-control input-class"  value="<?php echo $edit->dt_other;?>" name="dt_other"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">FIX TRAVEL ALLOWANCE	</label>
                                <input type="text" required class="form-control input-class" value="<?php echo $edit->dt_fix_ta;?>" name="dt_fix_ta"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">TOTAL DUES	</label>
                                <input type="text" readonly class="form-control input-class1"  value="<?php echo $edit->dt_dues;?>" name="dt_dues"/>
                              </div>


</div> 
<div class="col-md-6">
  <h5 class="text-danger">Deduction</h5>

  
  <div class="form-group"> 
                                <label for="email">GPF SUBSCRIPTION	</label>
                                <input type="text" required class="form-control input-class2"  value="<?php echo $edit->dt_gpf;?>" name="dt_gpf"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">GPF RECOVERY	</label>
                                <input type="text" required class="form-control input-class2"  value="<?php echo $edit->dt_gpf_recv;?>" name="dt_gpf_recv"/>
                              </div>


                              <div class="form-group"> 
                                <label for="email">GIS	</label>
                                <input type="text" required class="form-control input-class2"  value="<?php echo $edit->dt_gis;?>" name="dt_gis"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">FESTIVAL RECOVERY</label>
                                <input type="text" required class="form-control input-class2"  value="<?php echo $edit->dt_fest;?>" name="dt_fest"/>
                              </div>


  <div class="form-group"> 
                                <label for="email">HOUSE RENT</label>
                                <input type="text" required class="form-control input-class2"  value="<?php echo $edit->dt_hre_recv;?>" name="dt_hre_recv"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">WATER CHARGES</label>
                                <input type="text" required class="form-control input-class2"  value="<?php echo $edit->dt_water;?>" name="dt_water"/>
                              </div>

                              

                              

                            
                            
                              

                              <div class="form-group"> 
                                <label for="email">INCOME TAX		</label>
                                <input type="text" required class="form-control input-class2"  value="<?php echo $edit->dt_tax;?>" name="dt_tax"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">TOTAL DEDUCTIONS	</label>
                                <input type="text" readonly class="form-control input-class22"  value="<?php echo $edit->dt_ded;?>" name="dt_ded"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">NET SALARY	</label>
                                <input type="text" readonly class="form-control" id="netsal"  value="<?php echo $edit->dt_dues-$edit->dt_ded;?>"/>
                              </div>
</div>
</div> 
                              
                              

                              

                              
                              

</div>
<br/>
<button type="submit" class="btn btn-success">UPDATE DATA</button>
</form>
<script>
	$(document).ready(function(){
      $("#dt_sal_ddo").keyup(function(){
            var code=$(this).val();
            if(code.length>3){
                $.ajax({
                  type: "POST",
                  url: '<?php echo base_url();?>admin/ajax_chk_ddo',
                  data: {code:code},
                  success: function(res){
                            if(res>0){
                    $("#ddoid").val(res); 
                    $("#ddo_error").text("");             
                }
                else{
                    $("#ddo_error").text("External DDO");
                    $("#ddoid").val("");  
                }
                      }
                });
            }
      });

    $(".input-class").keyup(function () {
        var sum = 0;
        $(".input-class").each(function () {
            var value = parseFloat($(this).val()) || 0; // Convert to number, default to 0 if empty
            sum += value;
        });
        $(".input-class1").val(sum);
        var net=$(".input-class1").val()-$(".input-class22").val();
        $("#netsal").val(net);
    });

    $(".input-class2").keyup(function () {
        var sum = 0;
        $(".input-class2").each(function () {
            var value = parseFloat($(this).val()) || 0; // Convert to number, default to 0 if empty
            sum += value;
        });
        $(".input-class22").val(sum);
        
        var net=$(".input-class1").val()-$(".input-class22").val();
        $("#netsal").val(net);
    });

		$("#editform").submit(function(e){e.preventDefault();
            var formdata=$(this).serialize();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_submit_edit',
				 data: {formdata:formdata},
				 success: function(res){
         if(res==0){
             $("#editform").html('<div class="alert alert-success text-center"><h2><i class="bi bi-check bi-2x"></i><br/>Data Updated Successfully</h2></div>')
         }else{
                      alert(res);
                    }
					 //$("#desg").html(res);
				 }
			 });
		});
    
    });   
</script>