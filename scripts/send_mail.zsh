#!/bin/zsh

# Check if all required parameters are provided
if [[ $# -ne 4 ]]; then
    echo "Usage: $0 <receiver_email> <sender_email> <subject> <message>"
    exit 1
fi

# Assign parameters to variables
receiver_email="$1"
sender_email="$2"
subject="$3"
message="$4"

# Send the email using sendmail
echo -e "Subject: $subject\nFrom: $sender_email\nTo: $receiver_email\n\n$message" | sendmail -t

if [[ $? -eq 0 ]]; then
    echo "Email sent successfully."
else
    echo "Failed to send email."
    exit 1
fi
