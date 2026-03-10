<?php 
session_start(); 
// লগইন চেক
if(!isset($_SESSION['valid'])) { header('Location: login.php'); exit(); }
include_once("connection.php");

// ইউআরএল থেকে প্রোডাক্ট আইডি নেওয়া
if(!isset($_GET['id'])) { header('Location: sale.php'); exit(); }
$product_id = mysqli_real_escape_string($mysqli, $_GET['id']);

// প্রোডাক্টের বিস্তারিত তথ্য ডাটাবেস থেকে আনা
$res = mysqli_query($mysqli, "SELECT * FROM products WHERE id = $product_id");
$product = mysqli_fetch_assoc($res);

if(!$product) { echo "Product not found!"; exit(); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* রেসপন্সিভ এবং স্ট্যান্ডার্ড লেআউট */
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        body { background:#f4f7f6; padding: 40px 20px; color: #333; }
        
        .checkout-container { max-width: 900px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .payment-card, .order-summary { background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .payment-card { border-top: 6px solid #27ae60; }
        
        h3 { color: #2c3e50; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 14px; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none; font-size: 14px; }
        
        /* পেমেন্ট বাটন স্টাইল */
        .btn-confirm { width: 100%; background: #27ae60; color: white; border: none; padding: 15px; border-radius: 8px; font-weight: 600; font-size: 16px; cursor: pointer; transition: 0.3s; }
        .btn-confirm:hover { background: #219150; transform: translateY(-2px); }

        .method-box { background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #eee; margin-bottom: 10px; }
        .payment-info { background: #fff4e5; border-left: 4px solid #e67e22; padding: 10px; font-size: 13px; margin-bottom: 20px; color: #af640d; }

        @media (max-width: 768px) { .checkout-container { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="checkout-container">
    <div class="order-summary">
        <h3><i class="fa-solid fa-cart-shopping"></i> Order Summary</h3>
        <div style="background: #fdfdfd; padding: 20px; border-radius: 10px; border: 1px solid #f0f0f0;">
            <p style="margin-bottom: 5px; color: #777;">Product Name:</p>
            <p style="font-weight: 600; font-size: 18px;"><?php echo htmlspecialchars($product['name']); ?></p>
            <div style="margin: 20px 0;">
                <p style="margin-bottom: 5px; color: #777;">Total Payable:</p>
                <p style="font-size: 28px; color: #27ae60; font-weight: 700;">৳ <?php echo number_format($product['price'], 2); ?></p>
            </div>
        </div>
        <p style="font-size: 12px; color: #999; margin-top: 15px; line-height: 1.5;">
            * পেমেন্ট সম্পন্ন করার পর ট্রানজেকশন আইডি প্রদান করুন। ভুল তথ্য দিলে অর্ডার বাতিল হতে পারে।
        </p>
    </div>

    <div class="payment-card">
        <h3><i class="fa-solid fa-shield-halved"></i> Payment Details</h3>
        
        <div class="payment-info">
            <strong>Personal Number:</strong> 017XXXXXXXX (bKash/Nagad)
        </div>
        
        <form action="process_payment.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            
            <div class="form-group">
                <label>Select Method</label>
                <select name="method" required>
                    <option value="bKash">bKash</option>
                    <option value="Nagad">Nagad</option>
                    <option value="Rocket">Rocket</option>
                </select>
            </div>

            <div class="form-group">
                <label>Your Phone Number</label>
                <input type="text" name="sender_number" placeholder="01XXXXXXXXX" required pattern="[0-9]{11}">
            </div>

            <div class="form-group">
                <label>Transaction ID (TrxID)</label>
                <input type="text" name="trx_id" placeholder="Ex: 8N7X6W5V" required style="text-transform: uppercase;">
            </div>

            <button type="submit" name="submit_payment" class="btn-confirm">
                <i class="fa-solid fa-lock"></i> Confirm Payment
            </button>
        </form>
    </div>
</div>

</body>
</html>