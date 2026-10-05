<?php
// Initialize a message variable to show success or error alerts
$message = "";

// Connect to the database
$conn = new mysqli("localhost", "root", "", "cbt_app");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form data when it is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Use real_escape_string to prevent SQL injection (Good practice for your CV!)
    $question_text = $conn->real_escape_string($_POST['question_text']);
    $option_a = $conn->real_escape_string($_POST['option_a']);
    $option_b = $conn->real_escape_string($_POST['option_b']);
    $option_c = $conn->real_escape_string($_POST['option_c']);
    $option_d = $conn->real_escape_string($_POST['option_d']);
    $correct_option = $conn->real_escape_string($_POST['correct_option']);

    // Insert the new question into the database
    $sql = "INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_option) 
            VALUES ('$question_text', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option')";

    if ($conn->query($sql) === TRUE) {
        $message = "<div class='success'>New question added successfully!</div>";
    } else {
        $message = "<div class='error'>Error: " . $conn->error . "</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CBT Admin Panel</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f9; padding: 40px; }
        .admin-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; width: 100%; font-size: 16px; }
        button:hover { background: #218838; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; text-align: center; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px; text-align: center; }
        .nav-link { display: block; text-align: center; margin-top: 20px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="admin-container">
    <h2>Add New Exam Question</h2>
    
    <?php echo $message; ?>

    <form action="admin.php" method="POST">
        <div class="form-group">
            <label>Question Text:</label>
            <input type="text" name="question_text" required placeholder="e.g., What does PHP stand for?">
        </div>
        
        <div class="form-group">
            <label>Option A:</label>
            <input type="text" name="option_a" required>
        </div>
        
        <div class="form-group">
            <label>Option B:</label>
            <input type="text" name="option_b" required>
        </div>
        
        <div class="form-group">
            <label>Option C:</label>
            <input type="text" name="option_c" required>
        </div>
        
        <div class="form-group">
            <label>Option D:</label>
            <input type="text" name="option_d" required>
        </div>
        
        <div class="form-group">
            <label>Correct Option:</label>
            <select name="correct_option" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>

        <button type="submit">Add Question</button>
    </form>
    
    <a href="index.php" class="nav-link">Go to Examination Page</a>
</div>

</body>
</html>