<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="format-detection" content = "telephone=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Chocalate</title>
    
    <!-- favicon icon -->
    <link rel="icon" href="<?php echo base_url();?>assets/images/favicon.ico">
    <!-- Ioons -->
    <link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet"> <!-- font-awesome.min css -->
    
    <!-- CSS Stylesheet -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet"> <!-- bootstrap.min css -->
    <link href="<?php echo base_url();?>assets/css/slick.css" rel="stylesheet"> <!-- slick css -->
    <link href="<?php echo base_url();?>assets/css/slick-theme.css" rel="stylesheet"> <!-- slick-theme css -->
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet"> <!-- style css -->
	<link href="<?php echo base_url();?>assets/css/css3.css" rel="stylesheet"> <!-- css3 style -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head> 

<body>

	<div id="wrapper">
    
    	<!-- ****************** Header  Section ****************** -->
        <header id="header">
        	<div class="top-bar">
            	<div class="container">
                	<div class="row">
                    	<div class="col-sm-6">
                        	<div class="header-top-left">
                            <a href="#">For Bulk Order?</a>
                            <span>Call us at +1800-621-3294</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        	<div class="header-top-right">
                            	<ul class="list-inline">
                                    <li class="searchBox">
                                    	<a href="javascript:void(0);" class="search-boxSmall"><i class="fa fa-search"></i>Search</a>
                                        <div class="search-box">
                                            <div class="icon"><i class="icon icon-search"></i></div>
                                            <div class="search-view">
                                                <input type="text" value="" placeholder="Enter a search term …" />
                                                <button type="submit" value=""><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </li> 
                                    <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i>My Wishlist</a></li>
                                    <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i>Login/Register</a></li>
                                    <li class="cart-items">
                                    	<a href="javascript:void(0);" class="cart-icon"><i class="fa fa-shopping-basket" aria-hidden="true"></i><span class="badge">2</span></a>
                                    	<div class="cart-table">
                                        	<table class="table">
                                            	<tbody>
                                                	<tr>
                                                    	<td>
                                                        	<img src="<?php echo base_url();?>assets/images/cart-img1.jpg" alt="" />
                                                        </td>
                                                        <td>
                                                        	<p class="name">Antique Gold </p>
                                                            <div class="price">$ 449.0</div>
                                                            <div class="qty"><input type="text" value="1" />
                                                            	<a href="#" class="btn btn-info">Update</a>
                                                            </div>
                                                        </td>
                                                        <td class="options text-right">
                                                        	<span><a href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
                                                            <span><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>
                                                        	<img src="<?php echo base_url();?>assets/images/cart-img2.jpg" alt="" />
                                                        </td>
                                                        <td>
                                                        	<p class="name">Antique Gold </p>
                                                            <div class="price">$ 449.0</div>
                                                            <div class="qty"><input type="text" value="1" />
                                                            	<a href="#" class="btn btn-info">Update</a>
                                                            </div>
                                                        </td>
                                                        <td class="options text-right">
                                                        	<span><a href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
                                                            <span><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span> 
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="total">
                                            	<label>TOTAL:</label>
                                                <span class="price">$ 898.0</span>
                                            </div>
                                            <div class="checkout">
                                            	<a href="checkout.html" class="btn btn-info btn-block">Checkout</a>
												<a href="cart.html" class="btn btn-primary btn-block">View cart</a>
                                            </div>
                                        </div> 
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo base_url();?>"><img width="150px" src="<?php echo base_url();?>assets/images/logo.png" alt="Logo" /></a> 
                    </div> 
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <?php $mcats=$this->db->get("mcategory")->result();
									foreach($mcats as $mcat){?>
                            <li class="has-child"><a href="#"><?php echo $mcat->mcat_name;?></span></a>
                            	<ul class="dropdown-menu">
                                	<li>
                                    	<ul><?php  $this->db->order_by("csort","asc");$this->db->limit(10);
                 $cat=$this->db->get_where("category",array("cat_status"=>"","mid"=>$mcat->mid))->result();foreach($cat as $c){?> 
                                        	<li><a href="<?php echo base_url();?><?php echo str_replace(" ","-",$c->cat_name);?>/<?php echo $c->cid;?>" ><?php echo $c->cat_name;?></a></li>
                                            <?php }?>
                                        </ul>
                                        <ul class="hidden-xs">
                                        	<li class="occasion-offer">
                                            	<!--<label>Christmas Special Chocolate</label>-->
                                            	<img src="<?php echo base_url();?>assets/images/category/<?php echo $mcat->mcat_image;?>" alt="" />
                                                <!--<a href="#" class="send-gift">Send Christmas Chocolate Gift</a>-->
                                            </li> 
                                        </ul>
                                    </li>
                                    
                                </ul>
                            </li>
                            <?php }?>
                            <li><a href="#">Contact us</span></a>
                        </ul>
                    </div>
                </div>
            </div>
        </header> 