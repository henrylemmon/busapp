<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Invoice</title>

    <!-- Styles -->
    <style>
        body {
            background: #636b6f;
            /*background: #f4fcfc;*/

        }
        .outerContainer {
            background: #fff;
            width: 820px;
            height: 1040px;
            margin: 0 auto;
            position:relative;
        }
        .innerContainer {
            margin-right: auto;
            margin-left: auto;
            margin-top: 60px;
            width: 725px;
            height: 1000px;
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
            top: 30px;
            left: 0px;
        }
        table.middle {
            position: absolute;
            top: 250px;
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
            top: 400px;
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
            top: 938px;
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
            top: 380px;
            left: -35px;
        }
        .logo {
            position: absolute;
            top: 30px;
            left: 0px;
        }
        .logo-img {
            width: 156px;
            height: 123px;
            position: absolute;
            top: 25px;
            left: 25px;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

<div class="outerContainer">
    <div class="innerContainer">
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
                src="{{ asset('assets/logo/logo.jpg') }}"
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
                        {{ $address['job_address'] }}<br>
                        {{ $address['job_address2'] }}<br>
                        {{ $address['city'] . ',' }}
                        {{ $address['state'] . '.' }}<br>
                        {{ $address['zip'] }}<br>
                    </td>
                @endisset
                @empty($address)
                    <td class="middle">
                        {{ $customer['billing_address'] }}<br>
                        {{ $customer['billing_address2'] }}<br>
                        {{ $customer['city'] . ',' }}
                        {{ $customer['state'] . '.' }}<br>
                        {{ $customer['zip'] }}<br>
                    </td>
                @endempty
                <td class="middle">
                    {{ $customer['first_name'] }}
                    {{ $customer['last_name'] }}<br>
                    {{ $customer['billing_address'] }}<br>
                    {{ $customer['billing_address2'] }}<br>
                    {{ $customer['city'] . ',' }}
                    {{ $customer['state'] . '.' }}<br>
                    {{ $customer['zip'] }}<br>
                </td>
                <td class="middle">
                    {{ Carbon\Carbon::now()->isoFormat('MM/DD/YYYY') }}
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
    </div>
</div>
</body>
</html>
