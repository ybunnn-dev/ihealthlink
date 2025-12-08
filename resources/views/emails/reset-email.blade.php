<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Verification - IHealthLink</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; color: #566A7F; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); }
        .header { background: linear-gradient(135deg, #328E6E 0%, #279EFF 100%); padding: 40px 20px; text-align: center; }
        .logo-section { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 20px; }
        .logo-icon { width: 45px; height: 45px; color: #ffffff; flex-shrink: 0; }
        .logo-text { font-size: 22px; font-weight: 600; color: #ffffff; letter-spacing: -0.5px; }
        .header h1 { color: #ffffff; font-size: 24px; font-weight: 600; margin: 10px 0 5px 0; line-height: 1.3; }
        .header p { color: rgba(255, 255, 255, 0.9); font-size: 14px; margin-top: 5px; }
        .content { padding: 40px 30px; }
        .welcome { font-size: 16px; color: #566A7F; margin-bottom: 25px; line-height: 1.6; }
        .verification-box { background: linear-gradient(135deg, rgba(50, 142, 110, 0.05) 0%, rgba(39, 158, 255, 0.05) 100%); border-left: 4px solid #328E6E; padding: 25px; margin: 30px 0; border-radius: 6px; text-align: center; }
        .code-label { font-weight: 600; color: #328E6E; font-size: 14px; margin-bottom: 15px; display: block; }
        .verification-code { color: #328E6E; word-break: break-all; font-family: 'Courier New', monospace; background-color: #ffffff; padding: 18px 12px; border-radius: 4px; border: 2px solid #328E6E; font-size: 32px; font-weight: bold; letter-spacing: 8px; }
        .code-expiry { font-size: 12px; color: #697A8D; margin-top: 15px; font-style: italic; }
        .security-warning { background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 18px; margin: 25px 0; border-radius: 6px; color: #856404; font-size: 13px; line-height: 1.6; }
        .security-warning strong { display: block; margin-bottom: 8px; color: #333; }
        .instructions { background-color: #f9fafb; border: 1px solid #e0e0e0; padding: 20px; margin: 25px 0; border-radius: 6px; }
        .instructions h3 { color: #279EFF; font-size: 14px; font-weight: 600; margin-bottom: 12px; }
        .instructions ol { margin-left: 20px; color: #697A8D; font-size: 13px; line-height: 1.8; }
        .instructions li { margin-bottom: 8px; }
        .contact-info { background-color: #f0f8f5; border: 1px solid #d0e8e3; padding: 15px; margin-top: 20px; border-radius: 6px; font-size: 12px; color: #566A7F; }
        .contact-info strong { display: block; margin-bottom: 8px; color: #328E6E; }
        .contact-info a { color: #279EFF; text-decoration: none; }
        .footer-content { color: #697A8D; font-size: 13px; line-height: 1.6; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0; }
        .footer-signature { margin-top: 15px; color: #328E6E; font-weight: 600; }
        @media (max-width: 600px) {
            .container { border-radius: 0; }
            .content { padding: 20px 15px; }
            .header { padding: 20px 15px; }
            .header h1 { font-size: 20px; }
            .verification-code { font-size: 24px; letter-spacing: 4px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-section">
                <svg class="logo-icon" viewBox="0 0 90 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M51.9356 40.3515L53.3692 43.9599L55.1231 40.496L58.2998 34.2206L60.3291 39.4364L60.7637 40.5517H81.9961L63.7647 57.5917C60.6229 60.528 56.8727 62.5495 52.8945 63.6601C44.0894 66.5725 33.8877 64.7375 26.8428 58.1532L8.01173 40.5517H39.8457L40.3545 39.6923L47.126 28.2489L51.9356 40.3515ZM7.32619 6.84755C17.0951 -2.28239 32.9335 -2.28265 42.7022 6.84755L45.0029 8.99892L47.2969 6.85537C57.0658 -2.27458 72.9042 -2.27483 82.6729 6.85537C91.4744 15.0821 92.3439 27.9135 85.2842 37.0517H63.1572L60.1406 29.2987L58.7197 25.6454L56.9492 29.1425L53.7539 35.4511L49.0635 23.6435L47.7471 20.33L45.9307 23.3983L37.8496 37.0517H4.71974C-2.34671 27.9128 -1.47841 15.0767 7.32619 6.84755ZM74.001 4.60244C72.8714 3.94228 71.4536 3.98197 70.3828 4.704C68.3681 6.06262 68.5602 9.01338 70.7383 10.1659L71.6865 10.6679C71.895 10.7782 72.0928 10.9067 72.2783 11.0507L72.9492 11.5712C75.03 13.1867 76.5836 15.3508 77.4180 17.7958L77.9024 19.2138C77.9673 19.4041 78.0145 19.5998 78.0449 19.7977L78.1113 20.2284C78.4751 22.6001 81.2939 23.7962 83.3125 22.4354C84.3704 21.7221 84.8944 20.4725 84.6533 19.2372L84.1406 16.6142C84.0465 16.1322 83.9036 15.6595 83.7129 15.204L83.2529 14.1044C82.2107 11.6147 80.5883 9.38565 78.5137 7.59267L77.8135 6.98818C77.4382 6.66391 77.0330 6.37349 76.6026 6.12197L74.0010 4.60244Z" fill="currentColor"/>
                </svg>
                <div class="logo-text">
                    <span class="ihealth">iHealth</span><span class="link">Link</span>
                </div>
            </div>
            <h1>Password Reset</h1>
            <p>Verification Required</p>
        </div>
        
        <div class="content">
            <p class="welcome">
                You've requested to reset your password for your IHealthLink account. Please use the verification code below to proceed.
            </p>
            
            <div class="verification-box">
                <span class="code-label">Your Verification Code:</span>
                <div class="verification-code">{{ $plainCode }}</div>
                <div class="code-expiry">This code expires in 30 minutes</div>
            </div>
            
            <div class="security-warning">
                <strong>🔒 Keep This Code Safe</strong>
                Never share this code with anyone. IHealthLink staff will never ask for your verification code.
            </div>
            
            <div class="instructions">
                <h3>What happens next:</h3>
                <ol>
                    <li>Return to the IHealthLink app</li>
                    <li>Enter the verification code above</li>
                    <li>Create your new password</li>
                </ol>
            </div>
            
            <div class="contact-info">
                <strong>Didn't Request This?</strong><br>
                If you didn't request a password reset, you can safely ignore this email. Your account remains secure.
            </div>
            
            <div class="footer-content">
                <p>Best regards,</p>
                <p class="footer-signature">IHealthLink - Barangay Health System Team</p>
            </div>
        </div>
    </div>
</body>
</html>