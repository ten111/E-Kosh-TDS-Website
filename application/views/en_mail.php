<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333333;
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }
        p {
            color: #666666;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Contact/ FreeTrial Enquiry</h2>
        
        <div class="footer">
        
            <p>Name: <?php echo $name;?> </p>
            <p>Email: <?php echo $email;?> </p>
            <p>Phone: <?php echo $phone;?> </p>
            <?php if(isset($service)){?>
            <p>Subject: <?php echo $service;?> </p>
            <?php } if(isset($message)){?>
            <p>Message: <?php echo $message;?> </p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
