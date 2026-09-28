<!DOCTYPE html>
<html class="no-js" lang="zxx">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>KrishiVatika</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	<link rel="icon" href="<?php echo base_url();?>assets/images/favicon.png">

	<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">

	<!-- FontAwesome CSS -->
	<link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">

	<!-- Elegent CSS -->
	<link href="<?php echo base_url();?>assets/css/elegent.min.css" rel="stylesheet">

	<!-- Plugins CSS -->
	<link href="<?php echo base_url();?>assets/css/plugins.css" rel="stylesheet">

	<!-- Helper CSS -->
	<link href="<?php echo base_url();?>assets/css/helper.css" rel="stylesheet">

	<!-- Main CSS -->
	<link href="<?php echo base_url();?>assets/css/main.css" rel="stylesheet">

	<!-- Modernizer JS -->
	<script src="<?php echo base_url();?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/vendor/jquery.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script>
	$(document).ready(function(){
		$("#usercity").change(function(){
			var ucity=$(this).val();
			if(ucity!=""){
			window.location.href = "<?php echo base_url();?>home/set_city/"+ucity; 
			}
		});
	});
	</script>
    <style>.list-group-item.active{ background:#489147; border:#489147;}.table td, .table th {padding: 5px;}</style>
</head>

<body>

	<!--=============================================
	=            Header         =
	=============================================-->

	<header>
		<!--=======  header top  =======-->

		<div class="header-top pt-10 pb-10 pt-lg-10 pb-lg-10 pt-md-10 pb-md-10">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center text-sm-left hidden-xs">
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12  text-center text-sm-right">
						<!-- header top menu -->
						<div class="header-top-menu">
							<ul>
                            <?php if($this->session->userdata("type")){
								?><li><b>  Hi, <?php echo $this->session->userdata("loggeduser");?></b></li>
                                <li> <a href="<?php echo base_url();?>admin"> <i class="fa fa-dashboard"></i> Dashboard</a></li>
								<li> <a href="<?php echo base_url();?>home/logout"> <i class="fa fa-sign-out"></i> Logout</a></li>
								<?php
							}else if($this->session->userdata("user")){?>
                            <li><img width="20px" class="img img-circle" src="<?php echo $this->session->userdata("img");?>"><b>  Hi, <?php echo $this->session->userdata("name");?></b></li>
									
			<li><a href="<?php echo base_url();?>home/wishlist"><i class="fa fa-heart"></i> My Wishlist</a></li>
            <li><a href="<?php echo base_url();?>home/orders"><i class="fa fa-shopping-cart"></i> My Orders</a></li>
            <?php if($this->cart->total_items()>0){?>
            <li><a href="<?php echo base_url();?>home/checkout"><i class="fa fa-check"></i> Checkout</a></li><?php }?>
            <li> <a href="<?php echo base_url();?>home/logout"> <i class="fa fa-sign-out"></i> Logout</a></li>
									
								</li>
                            <?php }else{?>
                            <li><a href="<?php echo base_url();?>home/login"><i class="fa fa-user"></i> Login/Signup</a></li>
                            <?php }?>&nbsp;&nbsp;
                            <select style="padding-left:5px;" id="usercity">
                            	<option value="">Select City</option>
                                <?php $this->db->select("*");
								      $this->db->from("stores");
									  $this->db->join("cities","cities.city_id=stores.st_city");
									  //$this->db->where();
									  $this->db->group_by("stores.st_city");
									  $cities=$this->db->get()->result();
									  foreach($cities as $ct){?>
                                      <option value="<?php echo $ct->city_id;?>" <?php if($this->session->userdata("city")==$ct->city_id){echo "selected";}?>><?php echo $ct->city_name;?></option><?php }?>
                            </select>
							</ul>
						</div>
						<!-- end of header top menu -->
					</div>
				</div>
			</div>
		</div>

		<!--=======  End of header top  =======-->

		<!--=======  header bottom  =======-->

		<div class="header-bottom header-bottom-one header-sticky">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-12 col-xs-6 text-lg-left text-md-center text-sm-center">
						<!-- logo -->
						<div class="logo mt-15 mb-15">
							<a href="<?php echo base_url();?>">
									<img src="<?php echo base_url();?>assets/images/logo.png" class="img-fluid" alt="">
								</a>
						</div>
						<!-- end of logo -->
					</div>
					<div class="col-md-9 col-sm-12 col-xs-6">
						<div class="menubar-top d-flex justify-content-between align-items-center flex-sm-wrap flex-md-wrap flex-lg-nowrap mt-sm-15">
							<!-- header phone number -->
							<div class="header-contact d-flex">
								<div class="phone-icon">
									<img src="<?php echo base_url();?>assets/images/icon-phone.png" class="img-fluid" alt="">
								</div>
								<div class="phone-number">
									Phone: <span class="number">1-888-123-456-89</span>
								</div>
							</div>
							<!-- end of header phone number -->
							<!-- search bar -->
							<div class="header-advance-search">
								<form action="#">
									<input type="text" placeholder="Search your product">
									<button><span class="icon_search"></span></button>
								</form>
							</div>
							<!-- end of search bar -->
							<!-- shopping cart -->
							<div class="shopping-cart" id="shopping-cart">
								<a href="<?php echo base_url();?>home/cart">
									<div class="cart-icon d-inline-block">
										<span class="icon_bag_alt"></span>
									</div>
									<div class="cart-info d-inline-block">
										<p>Shopping Cart 
											<span id="items_total">
							<?php echo $this->cart->total_items();?> item(s) - <i class="fa fa-inr"></i><b><?php echo $this->cart->total();?>/-</b>
											</span>
										</p>
									</div>
								</a>
							<!-- end of shopping cart -->

							<!-- cart floating box -->
							<div class="cart-floating-box" id="cart-floating-box">
								<?php if($this->cart->total_items()>0){
	 $tot=0;?>
<div class="cart-items">
	<?php  foreach($this->cart->contents() as $cart){?>
    <div class="cart-float-single-item d-flex">
        <!--<span class="remove-item"><a href="#"><i class="fa fa-times"></i></a></span>-->
        <div class="cart-float-single-item-image">
            <a href="#"><img src="<?php echo $cart['img'];?>" class="img-fluid" alt=""></a>
        </div>
        <div class="cart-float-single-item-desc">
            <p class="product-title"> <a href="#"><?php echo $cart['name'];?> </a></p>
            <p class="price"><span class="count"><?php echo $cart['pack'];?> <b>Qty. <?php echo $cart['qty'];?></b> x </span><?php  echo $subt=$cart['price'];?></p>
        </div>
    </div>
    <?php }?>
</div>
<div class="cart-calculation">
    <div class="calculation-details">
        <p class="total">Subtotal <span><i class="fa fa-inr"></i><?php echo $this->cart->total();?></span></p>
    </div>
    <div class="floating-cart-btn text-center">
        <a href="<?php echo base_url();?>home/checkout">Checkout</a>
        <a href="<?php echo base_url();?>home/cart">View Cart</a>
    </div>
</div>
<?php }else{?><h3 class="pull-right text-warning"><i class="fa fa-shopping-cart"></i> Your Cart is empty</h3>
<?php }?>
							</div>
							<!-- end of cart floating box -->
							</div>
						</div>

						<!-- navigation section -->
                        <div class="main-menu">
							<nav>
								<ul>
									<li><a href="<?php echo base_url();?>">Home</a></li>
                                    <?php $mcats=$this->db->get("mcategory")->result();
									foreach($mcats as $mcat){?>
                                    <li class="menu-item-has-children"><a href="#"><?php echo $mcat->mcat_name;?></a>
                                        <ul class="sub-menu">
                                        <?php  $this->db->order_by("csort","asc");$this->db->limit(10);
                 $cat=$this->db->get_where("category",array("cat_status"=>"","mid"=>$mcat->mid))->result();foreach($cat as $c){?> 
                                            <li class="menu-item-has-children"><a href="<?php echo base_url();?><?php echo str_replace(" ","-",$c->cat_name);?>/<?php echo $c->cid;?>" ><?php echo $c->cat_name;?></a>
                                                <ul class="sub-menu">
                                                <?php $this->db->order_by("sid","desc");
                        $subcat=$this->db->get_where("subcategory",array("cid"=>$c->cid))->result();
                                        foreach($subcat as $subc){?>
                                                    <li><a href="<?php echo base_url();?><?php echo str_replace(" ","-",$c->cat_name);?>/<?php echo str_replace(" ","-",$subc->subcat_name);?>/<?php echo $c->cid;?>/<?php echo $subc->sid;?>"><?php echo $subc->subcat_name;?></a></li>
                                                    <?php }?>
                                                </ul>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </li>
                                    <?php }?>
                                    <li><a href="#">About us</a></li>
                                    <li><a href="#">CONTACT</a></li>
                                    <li><a href=""><i style="border:2px solid; padding:5px;">Deals & Offers</i></a></li>
								</ul>
							</nav>
						</div>
						<!-- end of navigation section -->
					</div>
					<div class="col-12">
						<!-- Mobile Menu -->
						<div class="mobile-menu d-block d-lg-none"></div>
					</div>
				</div>
			</div>
		</div>
</header>