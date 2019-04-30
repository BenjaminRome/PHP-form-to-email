<?php 

    require(get_theme_file_path('vendor/autoload.php'));
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $ui_message = '';

    if($_POST["submit"]) {
        // Retrieve all of the form data
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $sender_email = $_POST["sender_email"];
        $sender_phone_number = $_POST["phone_number"];
        $sender_city = $_POST["city"];
        $sender_state = $_POST["state"];
        $sender_zip = $_POST["zip"];
        $services = $_POST["services"];
        $message = $_POST["description"];
        $additional_info = $_POST["additional_info"];

        //Check if all the required fields are filled out
        if ((isset($first_name) && trim($first_name != '')) && 
        (isset($last_name) && trim($last_name != '')) &&
        (isset($sender_email) && trim($sender_email != '')) && 
        (isset($sender_phone_number) && trim($sender_phone_number != '')) &&
        (isset($sender_city) && trim($sender_city != '')) && 
        (isset($sender_state) && trim($sender_state != '')) && 
        (isset($sender_zip) && trim($sender_zip != '')) && 
        (isset($services) && trim($services != '')) &&
        (isset($message) && trim($message != ''))) {

            //Create the body of the email
$email_body = "Quote requested by: $first_name, $last_name\n
Email: $sender_email, Phone: $sender_phone_number\n
City: $sender_city, State: $sender_state, Zip: $sender_zip\n\n
Service in question: $services\n
Message: $message\n
Additional Specs: $additional_info";
        
                //Create the PHPMailer object, retrieve file, and send
                $mail = new PHPMailer(TRUE);
                $mail->SetFrom($sender_email, $first_name);
                $mail->Subject = 'Quote Request Form';
                $mail->Body = $email_body;
                // This is the address that will be targetted
                $mail->AddAddress('SomeEmail@email.com');
        
                if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
                    $mail->AddAttachment($_FILES['fileToUpload']['tmp_name'],
                                        $_FILES['fileToUpload']['name']);
                }
        
                $mail->Send();
        
                $ui_message = "<h2>Thank you! Your response has been submitted.</h2>"; 
                
            // If all fields are not filled out, return an error message
            } else {
                $ui_message = '<h2 style="color: #8B2229">Please fill out all required fields.</h2>';
            }
        }

    get_header();
?>

<div class="main-wrapper" id="quote-page">
 
    <h1>Request a Quote</h1>
    <span id="required-fields-text"><h2>Required fields are marked with an</h2><h3 class="asterisk"> *</h3></span>
    <?=$ui_message ?>

    <form action="<?php echo site_url('/quote') ?>" method="post" enctype="multipart/form-data">
        <p class="form-text">
            <label>First Name *</label>
            <input type="text" name="first_name">
        </p>
        <p class="form-text">
            <label>Last Name *</label>
            <input type="text" name="last_name">
        </p>
        <p class="form-text">
            <label>Email *</label>
            <input type="email" name="sender_email">
        </p>
        <p class="form-text">
            <label>Phone Number *</label>
            <input type="text" name="phone_number">
        </p>
        <p class="form-text">
            <label>City *</label>
            <input type="text" name="city">
        </p>
        <p class="form-text">
            <label>State *</label>
            <input type="text" name="state">
        </p>
        <p class="form-text"> 
            <label>Zip *</label>
            <input type="text" name="zip">
        </p>      
        <p id="radio-buttons">
            <label>What service may we assist you with? *</label>
            <span><input type="radio" name="services" value="Assembly" checked="checked">Assembly</span>
            <span><input type="radio" name="services" value="CNC Machining">CNC Machining</span>
            <span><input type="radio" name="services" value="Hydroforming">Hydroforming</span>
            <span><input type="radio" name="services" value="Laser Cutting">Laser Cutting</span>
            <span><input type="radio" name="services" value="Welding">Welding</span>
        </p>
        <p class="form-text" id="textareaOne">
            <label>Describe your project *</label> 
            <textarea name="description" cols="20" rows="5"></textarea>
        </p>
        <p class="form-text" id="textareaTwo">
            <label>Please note if additional specs are required</label>
            <label id="form-help-text">i.e. NADCAP, First Article Inspections per AS9102, etc.</label>
            <textarea name="additional_info" cols="15" rows="5"></textarea>
        </p>
        <p class="form-text">
            <label>Add an attachment</label>
            <input type="file" name="fileToUpload">
        </p>
        <p class="button">
            <input id="submit-button" type="submit" value="Submit" name="submit">
        </p>
    </form>
</div>

<?php get_footer() ?>