<!DOCTYPE html>

<head>
    <style>
    body, p, div { font-size: 14pt; font-family: Nikosh;}

h3 { font-size: 15pt; margin-bottom:0; font-family: Nikosh; }
        #form {
            width: 90%;
            padding: 5px 0;
            margin: auto;
        }

        #table1 {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
        }

        input {
            border: none;
            border-bottom: 1px dotted black;
        }

        input:hover{
            cursor:pointer;
            background: yellow;
        }

        /* 
        #signature label {
            border: 1px solid black;
            display: inline-flex;
            flex-wrap: wrap;
            flex: 1;
            width: 20%;
            border-top: 1px solid black;
            align-items: space-between;
        } */
        #signature {
            margin: auto;
        }

        #labelSig {

            padding-right: 8rem;

        }

        #labelSig2 {
            padding-right: 8rem;
        }

        #labelSig3 {
            padding-right: 20rem;
        }
    </style>
</head>
<html>

<body>

    <div style="text-align:center;">
    <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left">Back</i> </a>&nbsp;&nbsp;&nbsp;                         
    
    <a href="{{ route('leavepdf',['id'=>$id,'name'=>$name,'uid'=>$uid]) }}">Print </a>
        <h1> আপডেট ডায়াগনষ্টিক </h1>
        <h3> ধাপ,জেলা রোড, রংপুর </h3>
        <h3> <u>নৈমিক্তিক ছুটি/কর্মস্থল ত্যাগের আবেদনপত্র</u> </h3>
    </div>



    <form action="/action_page.php" id="form">
        <span>
            <label for="name">১. আবেদন কারীর নামঃ</label>
            <input type'text" id="name">
        </span><br />


        <label for="podobi">২. পদবীঃ </label>
        <input type'text" id="podobi">
        </span><br />

        <span>
            <label for="chutir-shomoykal">৩. নৈমিক্তিক ছুটির সময়কালঃ </label>
            <label>তারিখঃ</label><input type="date" id="tarikh" /><label>
                হইতে </label><input type="date" /><label> তারিখ পর্যন্ত মোট </label><input type="number" /><label>
                দিন
            </label>
        </span><br />


        <label for="leave">৪. কর্মস্থল ত্যাগের তারিখঃ</label>
        <input type="date" id="leave-day">
        </span><br />

        <span>
            <label for="cause-of-leave">৫. উদ্দেশ্য/ছুটিরকারনঃ </label>
            <input type'text" id="cause-of-leave">
        </span><br />

        <span>
            <label for="adress">৬. ছুটিতে থাকাকালীন ঠিকানাঃ গ্রামঃ </label><input type'text" id="address"><label> পোস্টঃ
            </label><input><label> উপজেলাঃ </label><input><label> জেলাঃ </label><input>
            <br /><label> মোবাইল নংঃ </label><input type="number">
        </span><br />

        <span>
        <label>৭. বাৎসরিক বরাদ্দকৃত ছুটির পরিমানঃ </label><input type="text" value="{{$empLeaveAmount}} "><label>আদ্যাবধি ভোগকৃত ছুটির পরিমানঃ
            </label><input type="text" value={{$leave_count}}><label> পাওনা ছুটি </label><?php $g=$empLeaveAmount-$leave_count;?><input type="text" value="{{$g}}">
        </span> শেষ ছুটি গ্রহণের তারিখঃ <input type="text">@if($last_leave!=null) {{$last_leave->leave_dates}} @else @endif<br><br>
        <label> ৮. ছুটিকালীন সময়ে আবেদনকারীর ডিউটি কি ছিল এবং ডিউটি কি আছে তার বিবরনঃ </label><br /><br />
        <table border id="table1">
            <tr>
                <th> তারিখ </th>
                <th> আবেদনকারীর ডিউটি </th>
                <th> দায়িত্ব গ্রহণকারীর ডিউটি </th>
                <th> দায়িত্ব গ্রহণকারীর স্বাক্ষর </th>
            </tr>
            <tr>
                <td> 1 </td>
                <td> 2 </td>
                <td> 3 </td>
                <td> 4 </td>
            </tr>
        </table>
        </span><br /><br /><br /><br>
        <span id="signature">
            <span id="labelSig"> আবেদনকারীর স্বাক্ষর </span>
            <span id="labelSig"> বিভাগীয় ইনচার্জ / মন্তব্য </span>
            <span id="labelSig"> অ্যাসিস্ট্যান্ট ম্যানেজার এডমিন </span>
            <span> ম্যানেজার এডমিন / এ.জি.এম / জি.এম </span>
        </span><br /><br /><br />
    </form>

    <div style="text-align:center;">
        <h1> আপডেট ডায়াগনষ্টিক </h1>
        <h3> ধাপ,জেলা রোড, রংপুর </h3>
        <h3><u>আবেদন কারীর কপি </u> </h3>
    </div>



    <form action="/action_page.php" id="form">
        <span>
            <label for="name">১. আবেদন কারীর নামঃ</label>
            <input type'text" id="name">
        </span><br />


        <label for="podobi">২. পদবীঃ </label>
        <input type'text" id="podobi">
        </span><br />

        <span>
            <label for="chutir-shomoykal">৩. নৈমিক্তিক ছুটির সময়কালঃ </label>
            <label>তারিখঃ</label><input type="date" id="tarikh" /><label>
                হইতে </label><input type="date" /><label> তারিখ পর্যন্ত মোট </label><input type="number" /><label>
                দিন
            </label>
        </span><br /><br /><br />

        <span id="labelSig3">
            <label>আবেদনকারীর</label><input type="number"><label> দিনের ছুটি মঞ্জুর করা হল/গেল না </label><br />
            <label>ছুটি শেষে যোগদানের তারিখ ও সময়ঃ</label><input type="date"> ও <input type="time">
        </span>
        <span>
            <label>আবেদনকারীর স্বাক্ষর </label>
        </span>




        </span><br /><br /><br /><br>
        <span style="display: flex; flex-wrap:wrap;  justify-content: space-between;">
            <div style="width:25rem">অ্যাসিস্ট্যান্ট ম্যানেজার এডমিন <br /> আপডেট ডায়াগনষ্টিক , রংপুর</div>
            <div style="width:25rem">ম্যানেজার এডমিন/এ.জি.এম/জি.এম <br /> আপডেট ডায়াগনষ্টিক , রংপুর</div>
        </span>

    </form>
</body>

</html>