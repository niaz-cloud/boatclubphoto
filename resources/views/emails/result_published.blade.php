<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Exam Result Published</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f7fa; padding:30px;">

    <table width="600" align="center"
        style="background:#ffffff; padding:30px; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.1);">

        <tr>
            <td style="text-align:center;">
                <h2 style="color:#2c3e50;">Student Management System</h2>
                <p style="color:#7f8c8d;">Exam Result Notification</p>
                <hr>
            </td>
        </tr>

        <tr>
            <td>

                <p>Dear Guardian,</p>

                <p>
                    We are pleased to inform you that the exam results for the following student have been published.
                </p>

                <table width="100%" style="margin-top:20px; border-collapse: collapse;">

                    <tr>
                        <td style="padding:10px;"><strong>Student Name:</strong></td>
                        <td style="padding:10px;">{{ $student->name }}</td>
                    </tr>

                    <tr style="background:#f2f2f2;">
                        <td style="padding:10px;"><strong>Roll Number:</strong></td>
                        <td style="padding:10px;">{{ $student->roll_number }}</td>
                    </tr>

                    <tr>
                        <td style="padding:10px;"><strong>Class:</strong></td>
                        <td style="padding:10px;">{{ $student->class->name ?? 'N/A' }}</td>
                    </tr>

                </table>

                <p style="margin-top:20px;">
                    Please log in to the student portal to view the full result and performance details.
                </p>

                <p>
                    Thank you for your continued support.
                </p>

                <br>

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
