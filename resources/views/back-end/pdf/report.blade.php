<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

    <style>
      /* .container{
        margin-left: 20%;
        margin-top: 50px;
        margin-right: 30%;
      } */

    .indent-1 {float: left;}
    .indent-2 {
      width: 50%;
      margin-top:-2000px;
      float: right;
    }

    </style>
  </head>
  <body>
    <div class="container">
        Dear, <br>
        {{$emp->name}} (empID: {{$emp->id}})<br>
        @if($month=='01')
        <span >your Attendance Report of month <b>January</b> </span>
        @elseif($month=='02')
        <span >your Attendance Report of month <b>february</b> </span>
        @elseif($month=='03')
        <span >your Attendance Report of month <b>march</b> </span>
        @elseif($month=='04')
        <span >your Attendance Report of month <b>april</b> </span>
        @elseif($month=='05')
        <span >your Attendance Report of month <b>may</b> </span>
        @elseif($month=='06')
        <span >your Attendance Report of month <b>june</b> </span>
        @elseif($month=='07')
        <span >your Attendance Report of month <b>july</b> </span>
        @elseif($month=='08')
        <span >your Attendance Report of month <b>august</b> </span>
        @elseif($month=='09')
        <span >your Attendance Report of month <b>september</b> </span>
        @elseif($month=='10')
        <span >your Attendance Report of month <b>october</b> </span>
        @elseif($month=='11')
        <span >your Attendance Report of month <b>november</b> </span>
        @elseif($month=='12')
        <span >your Attendance Report of month <b>december</b> </span>
        @endif

      <br><br>
      <table border="1" style="border-collapse: collapse;
            width: 80%;
            margin: auto;">
        <thead>
          <tr>
            <td colspan="13" style="text-align:center"> Days</td>
            <td colspan="2" style="text-align:center"> Summary Days</td>
            <td style="text-align:center">Remarks</td>

          </tr>

        </thead>
        <br>
        <tbody>
          <tr>
          <td>P</td>
          <td>A</td>
          <td>L</td>

          <td>2L</td>
          <td>SL</td>
          <td>AL</td>
          <td>CL</td>
          <td>H</td>
          <td>OL</td>
          <td>GH</td>
          <td>T</td>
          <td>LWP</td>
          <td>NA</td>

          <td>Salary Deduction</td>
          <td>Total Late</td>
          </tr>
          <tr>
            <td>20</td>
            <td>2</td>
            <td>2</td>

            <td>1</td>
            <td>1</td>
            <td>1</td>
            <td>1</td>
            <td>5</td>
            <td>0</td>
            <td>2</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>

            <td>100</td>
            <td>2</td>
          </tr>
        </tbody>

      </table>

      <br><span>Date wise status:</span>
      <table border="1" >
        <thead >
          <tr>
            <td>date</td>
            @for($i=1;$i<=30;$i++)
              <td>{{$i}}</td>
            @endfor
          </tr>

        </thead>
        <tbody>
          <tr>
            <td>status</td>
            <td>P/P</td>
            <td>P/P</td>
            <td>P/L</td>
            <td>L/P</td>
            <td>L/L</td>
            <td>H</td>
            <td>H</td>

            <td>P/P</td>
            <td>P/P</td>
            <td>P/P</td>
            <td>P/P</td>
            <td>L/L</td>
            <td>H</td>
            <td>H</td>

            <td>P/L</td>
            <td>L/P</td>
            <td>P/P</td>
            <td>P/P</td>
            <td>P/P</td>
            <td>H</td>
            <td>H</td>

            <td>P/P</td>
            <td>P/P</td>
            <td>P/P</td>
            <td>L/P</td>
            <td>L/P</td>
            <td>H</td>
            <td>H</td>

            <td>P/L</td>
            <td>P/L</td>
          </tr>

        </tbody>

      </table>
      <br>
      <table border="1">
        <thead class="thead-dark">

          <tr>
            <td>date</td>
            @for($i=1;$i<=30;$i++)
              <td>{{$i}}</td>
            @endfor
          </tr>

        </thead>
        <tbody>
          <tr>
            <td>status</td>
            <td>P</td>
            <td>P</td>
            <td>P</td>
            <td>P</td>
            <td>L</td>
            <td>H</td>
            <td>H</td>

            <td>P</td>
            <td>P</td>
            <td>P</td>
            <td>P</td>
            <td>L</td>
            <td>H</td>
            <td>H</td>

            <td>P</td>
            <td>L</td>
            <td>P</td>
            <td>P</td>
            <td>P</td>
            <td>H</td>
            <td>H</td>

            <td>P</td>
            <td>P</td>
            <td>P</td>
            <td>L</td>
            <td>L</td>
            <td>H</td>
            <td>H</td>

            <td>P</td>
            <td>P</td>
          </tr>

        </tbody>

      </table>
<br><br>

<section class="indent-1">
    <!-- Section 1 -->
    <section>
        <div><table border=".5">
          <tr>
            <th>sign</th>
            <th>meaning</th>
          </tr>
          <tr>
            <td>A</td>
            <td>Absent</td>
          </tr>
          <tr>
            <td>2L</td>
            <td>Late in & Early out</td>
          </tr>
          <tr>
            <td>SL/AL/CL/OL</td>
            <td>Sick Leave/Annual Leave/Casual Leave/Others Leave</td>
          </tr>
          <tr>
            <td>P</td>
            <td>Present</td>
          </tr>
          <tr>
            <td>H</td>
            <td>Holiday</td>
          </tr>
          <tr>
            <td>GH</td>
            <td>Gov. Holiday</td>
          </tr>
          <tr>
            <td>T</td>
            <td>Tour</td>
          </tr>
        </table></div>
    </section>

    <!-- Section 2 -->
    <section class="indent-2">
        <div><table border=".5">
          <tr>
            <th>sign</th>
            <th>meaning</th>
          </tr>
          <tr>
            <td>P/P</td>
            <td>No problem</td>
          </tr>
          <tr>
            <td>L/L</td>
            <td>2 late(late in and early out)</td>
          </tr>
          <tr>
            <td>P/L</td>
            <td>1 late(early out)</td>
          </tr>
          <tr>
            <td>L/P</td>
            <td>1 late(late in)</td>
          </tr>
          <tr>
            <td>ML</td>
            <td>Manula Attendance Late</td>
          </tr>
          <tr>
            <td>LWP</td>
            <td>Leave without pay</td>
          </tr>

        </table></div>
    </section>
</section>

</div>
      <br><br><br>
      <div style="text-align: right;padding-right: 35px;padding-top: 60px;margin-top:100px;margin-right:200px;">

        <p>-------------------------------------</p>
        <p style="padding-right:30px;padding-top:-16px">(signature & date)</p>
    </div>



  </body>
</html>
