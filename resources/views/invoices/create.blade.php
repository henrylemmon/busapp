<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="{{ asset('\js\app.js') }}"></script>

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
            /*border: 1px solid black;
            padding:0.25rem 0.5rem;*/
            padding:0;
        }
        table.foot {
            position: absolute;
            top: 928px;
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
        input {
            border: 0;
            /*padding: 25px 0;*/
            font-family: inherit;
            font-size: inherit;
            margin: 0;
            width: 100%;
            height: 100%;
        }
        textarea {
            border: 0;
            font-family: inherit;
            font-size: inherit;
            width: 100%;
            height: 100%;
            resize: none;
        }
        select {
            font-family: inherit;
            font-size: inherit;
            margin: 0;
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body style="font-family: 'Times New Roman';font-size:16px;">
<div id="app"></div>
<div class="outerContainer">
    <div class="innerContainer">
        <form action="{{ $customer->path() . '/invoices' }}" method="POST">
            @csrf
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
                    <td class="middle">
                        <input
                            name="sales_person"
                            type="text"
                        >
                    </td>

                    <td class="middle">
                        {{--begin of it--}}
                            <select
                                name="job_address_id"
                                style="padding:3px 2px;"
                            >
                                @if(isset($customer->billingAddress()->id))
                                    <option
                                        value="{{ $customer->billingAddress()->id }}"
                                    >
                                        {{ $customer->billingAddress()->address }}
                                        @isset($customer->billingAddress()->address2)
                                            {{ $customer->billingAddress()->address2 }}
                                        @endisset
                                        {{ $customer->billingAddress()->city }}
                                        {{ $customer->billingAddress()->state }}
                                        {{ $customer->billingAddress()->zip }}
                                    </option>
                                @endif
                                @if(isset($customer->addresses[0]->id))
                                    @foreach($customer->addresses->where('billing_address', false) as $address)
                                        <option value="{{ $address->id }}">
                                            {{ $address->address }}
                                            @isset($address->address2)
                                                {{ $address->address2 }}
                                            @endisset
                                            {{ $address->city }}
                                            {{ $address->state }}
                                            {{ $address->zip }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">
                                        Go back and add an address!
                                    </option>
                                @endif
                            </select>
                        {{--end of it--}}
                    </td>

                    @isset($customer->billingAddress()->address)
                        <td class="middle">
                            {{ $customer->first_name }}
                            {{ $customer->last_name }}<br>
                            {{ $customer->billingAddress()->address }}<br>
                            @isset($customer->billingAddress()->address2)
                                {{ $customer->billingAddress()->address2 }}<br>
                            @endisset
                            {{ $customer->billingAddress()->city . ',' }}
                            {{ $customer->billingAddress()->state . '.' }}<br>
                            {{ $customer->billingAddress()->zip }}<br>
                        </td>
                    @endisset
                    @empty($customer->billingAddress()->address)
                        <td class="middle">
                            Go back and assign a billing address!
                        </td>
                    @endempty
                    <td class="middle">
                        <input type="text" name="billing_date">
                    </td>
                </tr>
            </table>

            <table class="main">
                <tr>
                    <th class="main" style="width:75%;">Description:</th>
                    <th class="main" style="width:25%;">Cost:</th>
                </tr>
                <tr>
                    <td class="main" style="height:500px;vertical-align:top;/*border-right:1px solid black;*/">
                        <textarea id="description" name="description"></textarea>
                    </td>
                    <td class="main" style="height:500px;vertical-align:top;">
                        <textarea id="cost_description" name="cost_description"></textarea>
                    </td>
                </tr>
            </table>

            <table class="foot">
                <tr>
                    <td rowspan="2" style="width:75%;text-align:center;">Thank You!</td>
                    <td class="foot" style="width:25%;font-weight:bold;">Total</td>
                </tr>
                <tr>
                    <td class="foot" style="height:20px;">
                        <input type="text" name="total">
                    </td>
                </tr>
            </table>
            <table style="position:absolute;top:1000px;left:0px;width:75%;">
                <tr>
                    <td>
                        <button
                            type="submit"
                            style="background:black;padding:5px 10px;color:white;cursor:pointer;outline:none"
                        >Save</button>
                    </td>
                    <td>
                        Completed
                        &nbsp;
                        <input
                            type="checkbox"
                            name="completed"
                            style="width:auto;height:auto;"
                        >
                    </td>
                    <td>
                        <div>
                            Paid
                            &nbsp;
                            <input
                                type="checkbox"
                                name="paid"
                                style="width:auto;height:auto;"
                            >
                        </div>
                    </td>
                    <td>
                        <a
                            href="{{$customer->path()}}"
                            style="background:black;padding:5px 10px;color:white;text-decoration:none;"
                        >Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<script>
    ClassicEditor
        .create( document.querySelector('#description'), {
            removePlugins: [
                'CKFinderUploadAdapter',
                'CKFinder',
                'EasyImage',
                'Image',
                'ImageCaption',
                'ImageStyle',
                'ImageToolbar',
                'ImageUpload',
                'Indent',
                'Link',
                'MediaEmbed',
                'PasteFromOffice',
                'Table',
                'TableToolbar',
                'BlockQuote'
            ],
            toolbar: [
                'bold',
                'italic',
                'bulletedList',
                'numberedList',
                'heading'
            ]
        } )
        .catch( error => {
            console.error( error );
        } );

    ClassicEditor
        .create( document.querySelector('#cost_description'), {
            removePlugins: [
                'CKFinderUploadAdapter',
                'CKFinder',
                'EasyImage',
                'Image',
                'ImageCaption',
                'ImageStyle',
                'ImageToolbar',
                'ImageUpload',
                'Indent',
                'Link',
                'MediaEmbed',
                'PasteFromOffice',
                'Table',
                'TableToolbar',
                'BlockQuote'
            ],
            toolbar: [
                'bold',
                'italic',
                'bulletedList',
                'numberedList'
            ]
        } )
        .catch( error => {
            console.error( error );
        } );
</script>
</body>
</html>
