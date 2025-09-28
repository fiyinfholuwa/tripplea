<?php
header("Access-Control-Allow-Origin: *"); // allow all domains, or replace * with your domain
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    exit(0);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname     = htmlspecialchars($_POST['fullname']);
    $organization = htmlspecialchars($_POST['organization']);
    $email        = htmlspecialchars($_POST['email']);
    $message      = htmlspecialchars($_POST['message']);

    // Receiver email
    $adminEmail = "alfred.atiba@gmail.com";
    $logoUrl = "https://thehpcatalyst.com/assets/images/logo.png";

    // Subject lines
    $subjectAdmin = "New Consultation Booking from $fullname";
    $subjectUser  = "We’ve Received Your Consultation Request";

    // Shared email header (logo + intro style)
    $emailHeader = "
    <div style='background:#f5f7fa;padding:30px;text-align:center;'>
        <img src='$logoUrl' alt='Logo' style='max-width:180px;margin-bottom:20px;'>
    </div>
    <div style='background:#ffffff;padding:25px;border-radius:8px;
        box-shadow:0 2px 8px rgba(0,0,0,0.05);font-family:Arial,Helvetica,sans-serif;
        color:#333;line-height:1.6;font-size:15px;'>
    ";

    // Email footer
    $emailFooter = "
        <p style='margin-top:30px;font-size:13px;color:#777;text-align:center;'>
            This email was sent by The HPCatalyst Team.<br>
            &copy; ".date("Y")." The HPCatalyst. All rights reserved.
        </p>
    </div>
    ";

    // Message to Admin
    $bodyAdmin = $emailHeader . "
        <h2 style='color:#0056b3;'>New Consultation Request</h2>
        <p><strong>Name:</strong> $fullname</p>
        <p><strong>Organization:</strong> $organization</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Message:</strong><br>$message</p>
    " . $emailFooter;

    // Message to User
    $bodyUser = $emailHeader . "
        <h2 style='color:#0056b3;'>Thank You, $fullname!</h2>
        <p>We’ve received your consultation request and our team will reach out to you shortly.</p>
        <p><strong>Your submitted details:</strong></p>
        <ul style='padding-left:15px;'>
            <li><strong>Name:</strong> $fullname</li>
            <li><strong>Organization:</strong> $organization</li>
            <li><strong>Email:</strong> $email</li>
            <li><strong>Message:</strong> $message</li>
        </ul>
        <p style='margin-top:20px;'>
            <a href='https://thehpcatalyst.com' 
               style='display:inline-block;padding:12px 20px;background:#0056b3;color:#fff;
               text-decoration:none;border-radius:5px;font-weight:bold;'>Visit Our Website</a>
        </p>
    " . $emailFooter;

    // Headers for HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: The HPCatalyst <no-reply@yourdomain.com>" . "\r\n";

    // Send to Admin
    $mailAdmin = mail($adminEmail, $subjectAdmin, $bodyAdmin, $headers);

    // Send to User
    $mailUser = mail($email, $subjectUser, $bodyUser, $headers);

    if ($mailAdmin && $mailUser) {
        echo "Your consultation request has been sent successfully!";
    } else {
        echo "Sorry, we could not send your request. Please try again.";
    }
}
?>
