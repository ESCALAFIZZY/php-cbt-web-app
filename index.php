<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "cbt_app");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch questions
$sql = "SELECT * FROM questions ORDER BY RAND() LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CBT Examination</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f9; padding: 40px; }
        .test-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
        button { margin-top: 20px; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="test-container">
        <h2>Computer Science Test</h2>
        <form action="grade.php" method="POST">
            <?php
            if ($result->num_rows > 0) {
                $q_num = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<p><strong>{$q_num}. " . $row["question_text"] . "</strong></p>";
                    echo "<input type='radio' name='q{$row['id']}' value='A' required> A) " . $row["option_a"] . "<br>";
                    echo "<input type='radio' name='q{$row['id']}' value='B'> B) " . $row["option_b"] . "<br>";
                    echo "<input type='radio' name='q{$row['id']}' value='C'> C) " . $row["option_c"] . "<br>";
                    echo "<input type='radio' name='q{$row['id']}' value='D'> D) " . $row["option_d"] . "<br><br>";
                    $q_num++;
                }
            } else {
                echo "<p>No questions found. Please add questions to the database.</p>";
            }
            ?>
            <button type="submit">Submit Test</button>
        </form>
    </div>
<script>
    // Set the time limit in minutes
    let timeLimitMinutes = 5; 
    let timeRemaining = timeLimitMinutes * 60; // Convert to seconds

    // Create the visual timer display at the top of the container
    const testContainer = document.querySelector('.test-container');
    const timerDisplay = document.createElement('h3');
    timerDisplay.style.color = '#dc3545'; // Make it red so it stands out
    testContainer.insertBefore(timerDisplay, testContainer.firstChild);

    // Update the timer every second
    const countdown = setInterval(function() {
        let minutes = Math.floor(timeRemaining / 60);
        let seconds = timeRemaining % 60;
        
        // Format seconds to always show two digits (e.g., "09" instead of "9")
        seconds = seconds < 10 ? "0" + seconds : seconds;
        
        timerDisplay.innerHTML = "Time Remaining: " + minutes + ":" + seconds;
        
        if (timeRemaining <= 0) {
            clearInterval(countdown);
            timerDisplay.innerHTML = "Time is up! Submitting...";
            // Automatically click the submit button
            document.querySelector('form').submit();
        }
        
        timeRemaining--;
    }, 1000);
</script>
</body>
</html>