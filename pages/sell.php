<?php
require_once '../includes/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $v_type = $_POST['type'];
    $condition = $_POST['condition'];
    $f_type = $_POST['fuel'];
    $city = $_POST['city'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $phone = $_POST['phone'];
    
    // Handle file upload
    $target_dir = "../uploads/";
    $imageFileType = strtolower(pathinfo($_FILES["vehicle_image"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $imageFileType; // Generate unique filename
    $target_file = $target_dir . $new_filename;
    
    // Check if image file is actual image
    if(isset($_FILES["vehicle_image"])) {
        $check = getimagesize($_FILES["vehicle_image"]["tmp_name"]);
        if($check !== false) {
            // Allow certain file formats
            if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                if (move_uploaded_file($_FILES["vehicle_image"]["tmp_name"], $target_file)) {
                    // File uploaded successfully, now insert into database
                    $sql = "INSERT INTO vehicle (make, model, year, v_type, `condition`, f_type, city, description, price, image, phone) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssssssssss", $make, $model, $year, $v_type, $condition, $f_type, $city, $description, $price, $new_filename, $phone);
                    
                    if ($stmt->execute()) {
                        echo "<script>alert('Vehicle added successfully!'); window.location.href='start.php';</script>";
                    } else {
                        echo "<script>alert('Error: " . $stmt->error . "');</script>";
                    }
                    $stmt->close();
                } else {
                    echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                }
            } else {
                echo "<script>alert('Sorry, only JPG, JPEG & PNG files are allowed.');</script>";
            }
        } else {
            echo "<script>alert('File is not an image.');</script>";
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Vehicle</title>
    <style>
        
        
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
        }

        .page-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .banner {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                        url('../assets/images/audi.jpg') no-repeat center;
            background-size: cover;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }

        .banner h1 {
            font-size: 2.5rem;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .banner p {
            font-size: 1.2rem;
            margin: 10px 0 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .home_container {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 10;
        }

        .homebtn {
            padding: 12px 24px;
            cursor: pointer;
            background-color: #ff3838;
            font-size: 15px;
            font-weight: bold;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .homebtn:hover {
            background-color: #d40000;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .content-wrapper {
            flex: 1;
            background: linear-gradient(to bottom, #0f2027, #203a43, #2c5364);

            padding: 40px 20px;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input[type="file"] {
            background: transparent;
            padding: 10px 0;
            border: none;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ff3838;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 15px rgba(255, 56, 56, 0.3);
        }

        .form-group select option {
            background: #333;
            color: white;
            padding: 10px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .submit-container {
            grid-column: span 2;
            text-align: center;
            margin-top: 20px;
        }

        .submit-btn {
            background: #ff3838;
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 200px;
        }

        .submit-btn:hover {
            background: #d40000;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 56, 56, 0.4);
        }

        @media (max-width: 768px) {
            .banner {
                height: 200px;
            }

            .banner h1 {
                font-size: 2rem;
            }

            .form-container {
                padding: 20px;
                margin: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }

            .submit-btn {
                width: 100%;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-container {
            animation: fadeIn 0.8s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: #ff3838;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #d40000;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="banner">
            <div class="home_container">
                <a href="start.php" class="homebtn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Home
                </a>
            </div>
            <h1>Sell Your Vehicle</h1>
            <p>List your vehicle and reach thousands of potential buyers</p>
        </div>
        
        <div class="content-wrapper">
            <form class="form-container" action="" method="post" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="make">Vehicle Make</label>
                        <input type="text" name="make" id="make" required placeholder="e.g. Toyota">
                    </div>
                    
                    <div class="form-group">
                        <label for="model">Model</label>
                        <input type="text" name="model" id="model" required placeholder="e.g. Corolla">
                    </div>
                    
                    <div class="form-group">
                        <label for="year">Manufacturing Year</label>
                        <input type="text" name="year" id="year" required placeholder="e.g. 2020">
                    </div>
                    
                    <div class="form-group">
                        <label for="type">Vehicle Type</label>
                        <select name="type" id="type" required>
                            <option value="">Select Vehicle Type</option>
                            <option value="motorbike">Motor Bike</option>
                            <option value="car">Car</option>
                            <option value="van">Van</option>
                            <option value="jeep">Jeep</option>
                            <option value="bus">Bus</option>
                            <option value="lorry">Lorry</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="condition">Vehicle Condition</label>
                        <select name="condition" id="condition" required>
                            <option value="">Select Condition</option>
                            <option value="brandnew">Brand New</option>
                            <option value="used">Used</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="fuel">Fuel Type</label>
                        <select name="fuel" id="fuel" required>
                            <option value="">Select Fuel Type</option>
                            <option value="petrol">Petrol</option>
                            <option value="diesel">Diesel</option>
                            <option value="electric">Electric</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" required placeholder="Your City">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Contact Number</label>
                        <input type="tel" name="phone" id="phone" pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number" required placeholder="Your Phone Number">
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Price (LKR)</label>
                        <input type="text" name="price" id="price" required placeholder="Vehicle Price">
                    </div>
                    
                    <div class="form-group">
                        <label for="vehicle_image">Vehicle Image</label>
                        <input type="file" name="vehicle_image" id="vehicle_image" accept="image/*" required>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="description">Vehicle Description</label>
                        <textarea name="description" id="description" rows="4" required placeholder="Provide detailed information about your vehicle..."></textarea>
                    </div>
                    
                    <div class="submit-container">
                        <button type="submit" class="submit-btn">List Your Vehicle</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>