<!DOCTYPE html>
<html>

  <head>
      <meta charset="UTF-8">
      <title>Task Assignment</title>
      <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60vh;
            width : 100vh;
        }

        .card {
            margin-top:200px;
            padding: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 500px;
            text-align: center;
            width: 100%; /* Added width property */

        }
    </style>
  </head>

  <body>
      <div class="card">

          <h2>Task Assignment</h2>
          <p>Dear {{ $data['userName'] }}!,</p>
          <p>I hope this email finds you well. I am reaching out to assign a task to you that requires your expertise and
              attention. The details of the task are as follows:</p>

          <h3>Task Details</h3>
          <ul>
              <p>ProjectName: {{ $data['projectName'] }}</p>
              <p>Deadline: {{ $data['deadline'] }}</p>
              <p>Priority: {{ $data['priorities'] }}</p>
          </ul>

          <h3>Description</h3>
          <p>{{ $data['taskDescription'] }}</p>

          <p>Please review the task description carefully and ensure that you have a clear understanding of the
              expectations.
              If you have any questions or need further clarification, please don't hesitate to reach out to me. I'm more
              than
              happy to provide any additional information or guidance you may need.</p>

          <p>Please confirm your acceptance of this task by replying to this email. If you foresee any challenges or
              potential
              delays, please let me know as soon as possible so that we can discuss and make necessary adjustments.</p>

          <p>I trust your abilities and expertise in handling this task effectively. I have confidence in your skills and
              know
              that you will deliver excellent results.</p>

          <p>Thank you for your dedication and commitment to the team. I appreciate your efforts in taking on this task
              and
              contributing to our collective success.</p>

          <h2>Best regards,</h2>
          <p>{{ $data['teamLeadName'] }}<br>
                Team Lead<br>
              [Contact Information: {{ $data['teamLeadEmail'] }}]</p>
      </div>
  </body>

</html>