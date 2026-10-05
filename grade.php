<?php
// 1. Connect to the database
$conn = new mysqli("localhost", "root", "", "cbt_app");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$score = 0;
$total_questions = 0;
$corrections_html = ""; // We will store the corrections output here

// 2. Process the submitted form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    foreach ($_POST as $key => $user_answer) {
        
        if (strpos($key, 'q') === 0) {
            $total_questions++;
            $question_id = substr($key, 1);

            // Fetch both the correct option AND the question text this time
            $sql = "SELECT question_text, correct_option FROM questions WHERE id = $question_id";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $correct_answer = $row['correct_option'];
                $question_text = $row['question_text'];

                // Check if the answer is correct
                $is_correct = (strtoupper($user_answer) == strtoupper($correct_answer));
                
                if ($is_correct) {
                    $score++;
                    $border_color = "#28a745"; // Green
                    $status_icon = "✅ Correct";
                } else {
                    $border_color = "#dc3545"; // Red
                    $status_icon = "❌ Incorrect";
                }

                // Build the HTML for this specific question's correction
                $corrections_html .= "<div class='correction-card' style='border-left: 5px solid $border_color;'>";
                $corrections_html .= "<p class='q-text'><strong>" . htmlspecialchars($question_text) . "</strong></p>";
                $corrections_html .= "<p>Your Answer: <strong>Option " . htmlspecialchars(strtoupper($user_answer)) . "</strong> ($status_icon)</p>";
                
                // If they got it wrong, show them the correct answer
                if (!$is_correct) {
                    $corrections_html .= "<p class='correct-text'>Correct Answer: <strong>Option " . htmlspecialchars($correct_answer) . "</strong></p>";
                }
                $corrections_html .= "</div>";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CBT Results & Corrections</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f9; padding: 40px; }
        .results-container { 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            max-width: 600px; /* Made wider to fit the questions */
            margin: auto; 
        }
        .header-section { text-align: center; margin-bottom: 30px; }
        .pass { color: #28a745; }
        .fail { color: #dc3545; }
        
        /* Styles for the correction cards */
        .correction-card { 
            background: #f9f9f9; 
            padding: 15px; 
            margin-bottom: 15px; 
            border-radius: 4px;
        }
        .q-text { margin-top: 0; font-size: 16px; }
        .correct-text { color: #28a745; margin-bottom: 0;}
        
        .btn { 
            display: block; 
            text-align: center;
            margin-top: 30px; 
            padding: 12px 20px; 
            background: #007bff; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
        }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="results-container">
    <div class="header-section">
        <h2>Examination Complete</h2>
        <p>You scored <strong><?php echo $score; ?></strong> out of <strong><?php echo $total_questions; ?></strong>.</p>
        
        <?php
            $percentage = ($total_questions > 0) ? ($score / $total_questions) * 100 : 0;
            if ($percentage >= 50) {
                echo "<h3 class='pass'>Status: Passed (" . round($percentage) . "%)</h3>";
            } else {
                echo "<h3 class='fail'>Status: Failed (" . round($percentage) . "%)</h3>";
            }
        ?>
    </div>

    <h3>Review Your Answers:</h3>
    
    <!-- This prints all the correction cards we generated in the PHP loop above -->
    <?php echo $corrections_html; ?>

    <a href="index.php" class="btn">Retake Examination</a>
</div>

</body>
</html>