Subject: Task Completion - Confirmation

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Task Completion</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60vh;
            width: 100vh;
        }

        .card {
            margin-top: 300px;
            padding: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 500px;
            text-align: left;
            width: 100%;
        }

        .button {
            margin: 0;
            margin-left: 40%;
            position: absolute;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            background-color: #008CBA;
            border: none;
            color: white;
            padding: 15px 32px;
            text-decoration: none;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>Task Completion</h2>
        <p>Dear {{ $data['teamLeadName'] }},</p>
        <p>I hope this email finds you well. I am pleased to inform you that I have successfully completed the assigned task. Here are the details:</p>

        <h3>Task Details</h3>
        <p>Project Name: {{ $data['projectName'] }}</p>
        <p>Deadline: {{ $data['deadline'] }}</p>
        <p>Priority: {{ $data['priorities'] }}</p>

        <h3>Description</h3>
        <p>{{ $data['taskDescription'] }}</p>

        <p>I have thoroughly reviewed the task description and successfully accomplished all the requirements. I am confident that I have met the expectations set for this task.</p>

        <p>Thank you for entrusting me with this task. I appreciate the opportunity to contribute to our collective success.</p>

        <h2>Best regards,</h2>
        <!-- <a href="http://worklog.biafotech.com/taskmanagement-assignedtask" class="button">Go To Task</a> -->
        <p>{{ $data['userName'] }}<br>
            [Your Position]<br>
            [Contact Information: {{ $data['userEmail'] }}]</p>
    </div>
</body>

</html>