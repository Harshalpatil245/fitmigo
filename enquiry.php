<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("HTTP/1.1 405 Method Not Allowed");
    exit("Method Not Allowed");
}

function clean($v) { return htmlspecialchars(trim($v ?? ''), ENT_QUOTES, 'UTF-8'); }
function arr($v)   { return is_array($v) ? implode(', ', array_map('clean', $v)) : clean($v); }

// Required fields
$name  = clean($_POST['full_name'] ?? '');
$email = clean($_POST['email']     ?? '');
$phone = clean($_POST['phone']     ?? '');

if (empty($name) || empty($email) || empty($phone)) {
    echo "Please fill in all required fields (Name, Email, Phone).";
    exit;
}
if (!filter_var(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address.";
    exit;
}

// Collect all fields
$age            = clean($_POST['age']                ?? '');
$gender         = clean($_POST['gender']             ?? '');
$address        = clean($_POST['address']            ?? '');
$height         = clean($_POST['height_cm']          ?? '');
$weight         = clean($_POST['weight_kg']          ?? '');
$bmi            = clean($_POST['bmi']                ?? '');
$body_type      = clean($_POST['body_type']          ?? '');
$medical        = arr($_POST['medical']              ?? []);
$medications    = clean($_POST['medications']        ?? '');
$allergies      = clean($_POST['allergies']          ?? '');
$digestion      = clean($_POST['digestive_issues']   ?? '');
$occupation     = clean($_POST['occupation']         ?? '');
$work_type      = clean($_POST['work_type']          ?? '');
$sleep          = clean($_POST['sleep_duration']     ?? '');
$stress         = clean($_POST['stress_level']       ?? '');
$food_pref      = clean($_POST['food_preference']    ?? '');
$meals          = clean($_POST['meals_per_day']      ?? '');
$water          = clean($_POST['water_intake']       ?? '');
$outside        = clean($_POST['eating_outside']     ?? '');
$cravings       = clean($_POST['cravings']           ?? '');
$exercise_freq  = clean($_POST['exercise_routine']   ?? '');
$exercise_type  = clean($_POST['exercise_type']      ?? '');
$exercise_dur   = clean($_POST['exercise_duration']  ?? '');
$activity       = clean($_POST['activity_level']     ?? '');
$goals          = arr($_POST['goals']                ?? []);
$target_wt      = clean($_POST['target_weight']      ?? '');
$goal_dur       = clean($_POST['goal_duration']      ?? '');
$prev_diet      = clean($_POST['prev_diet']          ?? '');
$diet_details   = clean($_POST['diet_history_details'] ?? '');
$notes          = clean($_POST['additional_notes']   ?? '');
$signature      = clean($_POST['signature']          ?? '');
$decl_date      = clean($_POST['declaration_date']   ?? '');

$to      = "fitmigolife@gmail.com";
$subject = "New Health Enquiry — $name";

$body = "
FITMIGO — HEALTH & DIET ENQUIRY
================================

1. PERSONAL INFORMATION
   Full Name       : $name
   Age             : $age
   Gender          : $gender
   Contact Number  : $phone
   Email           : $email
   Address         : $address

2. PHYSICAL DETAILS
   Height (cm)     : $height
   Weight (kg)     : $weight
   BMI             : $bmi
   Body Type       : $body_type

3. HEALTH INFORMATION
   Medical Conditions : $medical
   Current Medications: $medications
   Allergies          : $allergies
   Digestive Issues   : $digestion

4. LIFESTYLE DETAILS
   Occupation      : $occupation
   Work Type       : $work_type
   Sleep Duration  : $sleep
   Stress Level    : $stress

5. FOOD HABITS
   Food Preference : $food_pref
   Meals per Day   : $meals
   Water Intake    : $water
   Eating Outside  : $outside
   Cravings        : $cravings

6. FITNESS & ACTIVITY
   Exercise Routine: $exercise_freq
   Type of Exercise: $exercise_type
   Duration        : $exercise_dur
   Activity Level  : $activity

7. GOALS
   Primary Goals   : $goals
   Target Weight   : $target_wt kg
   Goal Duration   : $goal_dur

8. PREVIOUS DIET HISTORY
   Followed Diet Before : $prev_diet
   Details              : $diet_details

9. ADDITIONAL NOTES
   $notes

10. DECLARATION
    Name/Signature  : $signature
    Date            : $decl_date

================================
Submitted via fitmigo.apnasociety.com
";

$headers  = "From: noreply@fitmigo.apnasociety.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $body, $headers)) {
    echo "success";
} else {
    echo "Failed to send. Please try again or contact us directly.";
}
?>
