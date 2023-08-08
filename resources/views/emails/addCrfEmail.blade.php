<!DOCTYPE html>
<html>

  <head>
      <meta charset="UTF-8">
      <title>CRF Assignment</title>
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
        <h2>Change Request Form</h2>
        <p>Dear {{ $data['managerName'] }}!,</p>
        <p>I hope this email finds you well. I am assigning you a Change Request Form that requires your expertise and attention. 
            The details of the CRF are as follows:</p>

        <h3>Crf Title</h3>
        <p>{{ $data['crf_title'] }}</p>

        <h3>Crf Details</h3>
        <p>Time Required: {{ $data['required_time_no'] }}{{-}}{{$data['required_time_type']}}</p>
        <p>Document Reference No: {{ $data['doc_ref_no'] }}{{-}}{{$data['crf_version']}}{{.}}{{$data['crf_version_float']}}</p>

        <h3>Requirement</h3>
        <p>Type Of Requirement :{{ $data['type_of_requirement'] }}</p>
        <p>Priority :{{ $data['priority'] }}</p>


        <p>Please review the CRF description carefully and ensure that you have a clear understanding of the
            expectations. If you have any questions or need further clarification, please don't hesitate to reach out to
            me. I'm more than happy to provide any additional information or guidance you may need.</p>

        <p>Thank you for your dedication and commitment to the team. I appreciate your efforts in taking on this CRF
            and contributing to our collective success.</p>

        <h2>Best regards,</h2>
        <!-- <a href= "http://worklog.biafotech.com/CRFmanagement-assignedCRF" class="button" >Go To CRF</a> -->
        <p>{{ $data['functionalLeadName'] }}<br>
            Functional Lead<br>
            [Contact Information: {{ $data['functionalLeadEmail'] }}]</p>
    </div>
</body>

</html>