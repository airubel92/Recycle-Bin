<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety Guidelines | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f0f4f8; color: #2c3e50; line-height: 1.6; }
        
        .hero-section {
            background: linear-gradient(135deg, #27ae60 0%, #1e8449 100%);
            color: white;
            padding: 80px 10% 100px;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%);
        }
        .hero-section h1 { font-size: 2.8rem; margin-bottom: 15px; font-weight: 700; }
        .hero-section p { font-size: 1.1rem; opacity: 0.9; max-width: 700px; margin: 0 auto; }

        .container { max-width: 1100px; margin: -50px auto 60px; padding: 0 20px; }

        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }

        .safety-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            text-align: center;
            border-bottom: 5px solid transparent;
        }
        .safety-card:hover {
            transform: translateY(-10px);
            border-bottom: 5px solid #27ae60;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }
        .icon-box {
            width: 80px;
            height: 80px;
            background: #e8f5e9;
            color: #27ae60;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 25px;
            transition: 0.3s;
        }
        .safety-card:hover .icon-box { background: #27ae60; color: white; }
        .safety-card h3 { margin-bottom: 15px; color: #2c3e50; font-weight: 600; }
        .safety-card p { color: #7f8c8d; font-size: 0.95rem; }

        .alert-box {
            background: #fff3cd;
            border-left: 6px solid #ffc107;
            padding: 25px;
            margin-top: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .alert-box i { font-size: 2rem; color: #856404; }

        .btn-home {
            display: inline-block;
            margin-top: 40px;
            padding: 12px 30px;
            background: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-home:hover { background: #27ae60; box-shadow: 0 5px 15px rgba(39,174,96,0.3); }

        @media (max-width: 768px) {
            .hero-section h1 { font-size: 2rem; }
            .container { margin-top: -30px; }
        }
    </style>
</head>
<body>

    <section class="hero-section">
        <h1><i class="fa-solid fa-shield-halved"></i> Safety First</h1>
        <p>আপনার নিরাপত্তা আমাদের কাছে সবচেয়ে গুরুত্বপূর্ণ। UIU RecycleBin-এ নিরাপদ কেনাবেচা নিশ্চিত করতে নিচের নির্দেশনাগুলো অনুসরণ করুন।</p>
    </section>

    <div class="container">
        <div class="grid">
            <div class="safety-card">
                <div class="icon-box"><i class="fa-solid fa-handshake"></i></div>
                <h3>পাবলিক প্লেসে লেনদেন</h3>
                <p>সবসময় ক্যাম্পাসের ভেতর যেমন- ক্যাফেটেরিয়া, লবি বা লাইব্রেরির সামনে দেখা করার চেষ্টা করুন। নির্জন স্থান এড়িয়ে চলুন।</p>
            </div>

            <div class="safety-card">
                <div class="icon-box"><i class="fa-solid fa-magnifying-glass"></i></div>
                <h3>পণ্য ভালোমতো যাচাই করুন</h3>
                <p>পণ্য হাতে পাওয়ার পর ভালোমতো পরীক্ষা করুন। ইলেকট্রনিক ডিভাইস হলে অন করে বা চার্জ দিয়ে চেক করে নিন।</p>
            </div>

            <div class="safety-card">
                <div class="icon-box"><i class="fa-solid fa-money-bill-transfer"></i></div>
                <h3>আগে টাকা পাঠাবেন না</h3>
                <p>পণ্য হাতে না পেয়ে কোনোভাবেই অগ্রিম টাকা (বিকাশ/নগদ) পাঠাবেন না। লেনদেন সরাসরি সম্পন্ন করা সবচেয়ে নিরাপদ।</p>
            </div>
        </div>

        <div class="alert-box">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <strong style="display:block; font-size:1.1rem; color:#856404;">সতর্কতা:</strong>
                <p style="color:#856404;">যদি কোনো ইউজারের আচরণ সন্দেহজনক মনে হয়, তবে সাথে সাথে প্রজেক্ট অ্যাডমিনের সাথে যোগাযোগ করুন।</p>
            </div>
        </div>

        <div style="text-align:center;">
            <a href="index.php" class="btn-home"><i class="fa-solid fa-house"></i> Back to Homepage</a>
        </div>
    </div>

</body>
</html>