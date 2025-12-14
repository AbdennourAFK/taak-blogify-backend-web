<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
        <h1 style="color: #1b1b18; margin-top: 0;">New Contact Form Submission</h1>
    </div>

    <div style="background-color: #ffffff; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;">
        <p><strong>Name:</strong> {{ $contact->name }}</p>
        <p><strong>Email:</strong> {{ $contact->email }}</p>
        <p><strong>Subject:</strong> {{ $contact->subject }}</p>
        
        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
            <p><strong>Message:</strong></p>
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 10px; white-space: pre-wrap;">{{ $contact->message }}</div>
        </div>

        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0; font-size: 12px; color: #666;">
            <p>Submitted on: {{ $contact->created_at->format('F d, Y \a\t g:i A') }}</p>
        </div>
    </div>

    <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px; font-size: 12px; color: #666; text-align: center;">
        <p>This is an automated email from the Blogify contact form.</p>
    </div>
</body>
</html>

