<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Fee Reminder</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f7fa; padding:20px;">

    <table width="600" align="center"
        style="background:white; border-radius:8px; padding:30px; box-shadow:0 2px 10px rgba(0,0,0,0.1);">

        <tr>
            <td style="text-align:center;">
                <h2 style="color:#2c3e50;">Student Management System</h2>
                <p style="color:#777;">Fee Payment Reminder</p>
                <hr>
            </td>
        </tr>

        <tr>
            <td>

                <p>Dear Guardian,</p>

                <p>
                    This is a friendly reminder that the monthly fee for the following student
                    has not yet been paid.
                </p>

                <table width="100%" style="margin:20px 0; border-collapse: collapse;">
                    <tr style="background:#f1f1f1;">
                        <td style="padding:10px;"><strong>Student Name</strong></td>
                        <td style="padding:10px;">{{ $student->name }}</td>
                    </tr>

                    <tr>
                        <td style="padding:10px;"><strong>Class</strong></td>
                        <td style="padding:10px;">{{ $student->class->name ?? 'N/A' }}</td>
                    </tr>

                    <tr style="background:#f1f1f1;">
                        <td style="padding:10px;"><strong>Status</strong></td>
                        <td style="padding:10px; color:red;"><strong>Unpaid</strong></td>
                    </tr>
                </table>

                <p>
                    Kindly arrange the payment at your earliest convenience to avoid any inconvenience.
                </p>

                <p>
                    If the payment has already been made, please ignore this message.
                </p>

                <br>

                <p>Thank you for your cooperation.</p>

                <p>
                    Regards,<br>
                    <strong>School Administration</strong>
                </p>

            </td>
        </tr>

        <tr>
            <td style="text-align:center; padding-top:20px; color:#999; font-size:12px;">
                © {{ date('Y') }} Student Management System. All rights reserved.
            </td>
        </tr>

    </table>

</body>

</html>
