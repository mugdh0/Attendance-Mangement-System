<!DOCTYPE html>

<head>
    <style>
    body{
        font-family: Nikosh;
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
                               
        <span style="font-size:24px">আপডেট ডায়াগনষ্টিক</span><br>
        <small> ধাপ,জেল রোড, রংপুর </small><br>
        <u>নৈমিক্তিক ছুটি/কর্মস্থল ত্যাগের আবেদনপত্র</u>
    </div>
    <br>

    <form action="/action_page.php" id="form">
        <span>
            <label for="name">১. আবেদনকারীর নামঃ</label>
            
        </span><br>


        <label for="podobi">২. পদবীঃ </label>
        
        </span><br>

        <span>
            <label for="chutir-shomoykal">৩. নৈমিক্তিক ছুটির সময়কালঃ </label>
            <label>তারিখঃ</label>...........................<label>
                হইতে </label>...........................<label> তারিখ পর্যন্ত মোট </label>.............<label>
                দিন
            </label>
        </span><br />


        <label for="leave">৪. কর্মস্থল ত্যাগের তারিখঃ</label>
        
        </span><br />

        <span>
            <label for="cause-of-leave">৫. উদ্দেশ্য/ছুটিরকারনঃ </label>
            
        </span><br />

        <span>
            <label for="adress">৬. ছুটিতে থাকাকালীন ঠিকানাঃ গ্রামঃ </label>......................<label> পোস্টঃ
            </label>..................<label> উপজেলাঃ </label>......................<label> জেলাঃ </label>......................
            <br /><label> মোবাইল নংঃ </label>..................................................
        </span><br />

        <span>
            <label>৭. বাৎসরিক বরাদ্দকৃত ছুটির পরিমানঃ </label><input type="text" value="{{$empLeaveAmount}}"> <label>আদ্যাবধি ভোগকৃত ছুটির পরিমানঃ
            </label><input type="text" value={{$leave_count}}><label> পাওনা ছুটি </label><?php $g=$empLeaveAmount-$leave_count;?><input type="text" value="{{$g}}">
        </span> শেষ ছুটি গ্রহণের তারিখঃ @if($last_leave!=null) {{$last_leave->leave_dates}} @else @endif<br><br>
        <label> ৮. ছুটিকালীন সময়ে আবেদনকারীর ডিউটি কি ছিল এবং ডিউটি কি আছে তার বিবরনঃ </label><br /><br />
        <table border="1" style="border-collapse: collapse;
            width: 80%;
            margin: auto;">
            <tr>
                <th> তারিখ </th>
                <th> আবেদনকারীর ডিউটি </th>
                <th> দায়িত্ব গ্রহণকারীর ডিউটি </th>
                <th> দায়িত্ব গ্রহণকারীর স্বাক্ষর </th>
            </tr>
            <tr>
                <td>. <br>. </td>
                <td>. <br>. </td>
                <td>. <br>. </td>
                <td>. <br>. </td>
            </tr>
        </table>
        </span><br><br><br><br>
        <span style="margin: auto;">
            <span style="padding-right: 100px;"> আবেদনকারীর স্বাক্ষর.......  </span>
            <span style="padding-right: 100px;"> বিভাগীয় ইনচার্জ / মন্তব্য....... </span>
            <span style="padding-right: 100px;"> অ্যাসিস্ট্যান্ট ম্যানেজার এডমিন....... </span>
            <span> ম্যানেজার এডমিন / এ.জি.এম / জি.এম </span>
        </span>
    </form><br><hr>

    <div style="text-align:center;">
                               
        <span style="font-size:24px">আপডেট ডায়াগনষ্টিক</span><br>
        <small> ধাপ,জেল রোড, রংপুর </small><br>
        <u>নৈমিক্তিক ছুটি/কর্মস্থল ত্যাগের আবেদনপত্র</u>
    </div>
    <br>



    <form action="/action_page.php" id="form">
        <span>
            <label for="name">১. আবেদনকারীর নামঃ</label>
            
        </span><br />


        <label for="podobi">২. পদবীঃ </label>
        
        </span><br />

        <span>
            <label for="chutir-shomoykal">৩. নৈমিক্তিক ছুটির সময়কালঃ </label>
            <label>তারিখঃ</label>..........................<label>
                হইতে </label>.........................<label> তারিখ পর্যন্ত মোট </label>...................
                দিন
            </label>
        </span><br /><br /><br />

        <span id="labelSig3">
            <label>আবেদনকারীর</label>...............<label> দিনের ছুটি মঞ্জুর করা হল/গেল না </label><br >
            <label>ছুটি শেষে যোগদানের তারিখ ও সময়ঃ</label>...................... ও ......................
        </span>
        <br>
        
        <div style="margin-left:500px;">আবেদনকারীর স্বাক্ষর </div>
        </span><br><br><br><br>
        <span style="">
            <div style="">অ্যাসিস্ট্যান্ট ম্যানেজার এডমিন <br> আপডেট ডায়াগনষ্টিক , রংপুর</div>
            <div style="margin-top:-49px; margin-left:400px;">ম্যানেজার এডমিন/এ.জি.এম/জি.এম <br> আপডেট ডায়াগনষ্টিক , রংপুর</div>
        </span>

    </form>
</body>

</html>