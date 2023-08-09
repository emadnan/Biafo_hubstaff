<!DOCTYPE html>
<html>

  <head>
      <meta charset="UTF-8">
      <title>Functional Specification Form</title>
      <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60vh;
            width : 100vh;
        }

        .card {
            margin-top:300px;
            padding: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 500px;
            text-align: left;
            width: 100%; /* Added width property */

        }
        .button{
            margin: 0;
            margin-left: 40%;
            position: absolute;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            background-color: #008CBA; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-decoration: none;
            /* display: inline-block; */
            font-size: 12px;
        }
        

    </style>
  </head>

  <body>
      <div class="card">

          <h2>Functional Specification Form</h2>
          <p>Dear {{ $data['memberName'] }},</p>
          <p>I hope this email finds you well. I am reaching out to assign a FSF to you that requires your expertise and
              attention. The details of the FSF are as follows:</p>

          <h3>FSF Details</h3>
            <p>wricef Id:               {{ $data['wricefId'] }}</p>
            <p>Type Of Development:     {{ $data['TypeOfDevelopment'] }}</p>
            <p>Project Name:            {{ $data['ProjectName'] }}</p>
            <p>Module Name:            {{ $data['ModuleName'] }}</p>
            <p>Priority:                {{ $data['priorities'] }}</p>


          <p>Please review the FSF description carefully and ensure that you have a clear understanding of the
              expectations.
              If you have any questions or need further clarification, please don't hesitate to reach out to me. I'm more
              than
              happy to provide any additional information or guidance you may need.</p>

          <p>Thank you for your dedication and commitment to the team. I appreciate your efforts in taking on this FSF
              and
              contributing to our collective success.</p>

          <h2>Best regards,</h2>
           <!-- <a href= "http://worklog.biafotech.com/fsf" class="button" >Go To FSF</a> -->
          <p>{{ $data['teamLeadName'] }}<br>
            Team Lead<br>
              {{ $data['teamLeadEmail'] }}</p>
              <img src='{{asset("biafotechlogos/biafoLogo.png")}}' alt="Image Description">
      </div>
  </body>

</html>