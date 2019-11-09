<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Invoice</title>

    <!-- Styles -->
    <style>
        body {
            /*background: #f4fcfc;*/
            background: #fff;
            position: relative;
        }
        table, th, td {
            border-collapse: collapse;
        }
        table {
            width:100%;
        }
        table.header {
            position: absolute;
            top: 0px;
            left: 0px;
        }
        table.middle {
            position: absolute;
            top: 220px;
            left: 0px;
        }
        th.middle {
            border:1px solid black;
            padding:0.25rem 0.5rem;
        }
        td.middle {
            border:1px solid black;
            padding:0.25rem 0.5rem;
            height:65px;
        }
        table.main {
            border: 1px solid black;
            position: absolute;
            top: 370px;
            left: 0px;
        }
        th.main {
            border: 1px solid black;
            padding:0.25rem 0.5rem;
        }
        td.main {
            border: 1px solid black;
            padding:0.25rem 0.5rem;
        }
        table.foot {
            position: absolute;
            top: 908px;
            left: 0px;
        }
        td.foot {
            border: 1px solid black;
            padding:0.25rem 0.5rem;
        }
        .watermark {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 350px;
            left: -35px;
        }
        .logo {
            position: absolute;
            top: 0px;
            left: 0px;
        }
        .logo-img {
            width: 156px;
            height: 123px;
            position: absolute;
            top: 25px;
            left: 25px;
        }
    </style>
</head>
<body>

<table class="header" style="border:0px solid black;">
    <tr>
        <td style="width:30%;height:175px;"></td>
        <td style="width:70%;text-align:center;padding-right:25px;">
            <div style="margin-bottom:10px;">
                <h1 style="margin-top:15px;font-size:50px;">Joe's Plumbing</h1>
                <p
                    style="font-size:10px;
                            font-variant:small-caps;
                            letter-spacing:4px;
                            margin-top:-35px;">
                    &bull; ON TIME &bull; ON BUDGET &bull;
                </p>
            </div>
            <p style="text-align:left;margin-left:115px;font-size:12px;font-family:sans-serif;">
                1122 BoogieBoogie Ave.<br>
                Long Angeles, CA.<br>
                90802
            </p>
        </td>
    </tr>
</table>
<div class="logo">
    <img
        class="logo-img"
        src="{{ asset('assets/logo/OptimizedLogo.jpg') }}"
        alt="Running Plumber">
</div>

<div
    class="watermark"
    style="background:url({{ asset('assets/watermark/OptimizedWaterMark.png') }}) no-repeat;">
</div>

<table class="middle">
    <tr>
        <th class="middle" style="width:25%">
            Sales Person
        </th>
        <th class="middle" style="width:30%;">
            Job Location
        </th>
        <th class="middle" style="width:30%">
            Bill To
        </th>
        <th class="middle" style="width:15%">
            Date
        </th>
    </tr>

    <tr>
        <td class="middle">Hank</td>
        @isset($address)
            <td class="middle">
                Henry
            </td>
        @endisset
        @empty($address)
            <td class="middle">
                Job Location
            </td>
        @endempty
        <td class="middle">
            Billing Address
        </td>
        <td class="middle">
            The Date
        </td>
    </tr>
</table>

<table class="main">
    <tr>
        <th class="main" style="width:75%;">Description:</th>
        <th class="main" style="width:25%;">Cost:</th>
    </tr>
    <tr>
        <td class="main" style="height:500px;vertical-align:top;">
            I am three rows high and I do not give a shit and I hope that you do not either and then again it is so fruitful but.
        </td>
        <td class="main" style="vertical-align:top;">
            there wehre two rows below but now there is not I added an extra table to compensate.
        </td>
    </tr>
</table>

<table class="foot">
    <tr>
        <td rowspan="2" style="width:75%;text-align:center;">Thank You!</td>
        <td class="foot" style="width:25%;font-weight:bold;">Total</td>
    </tr>
    <tr>
        <td class="foot" style="height:20px;"></td>
    </tr>
</table>

</body>
</html>
