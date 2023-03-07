<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <style type="text/css">
        .ExternalClass {
            width: 100%;
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        body {
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }

        body {
            margin: 0;
            padding: 0;
        }

        table td {
            border-collapse: collapse;
        }

        p {
            margin: 0;
            padding: 0;
            margin-bottom: 0;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: black;
            line-height: 100%;
        }

        a,
        a:link {
            color: #B10035;
            text-decoration: none;
        }

        body,
        #body_style {
            background: #f5f5f5;
            min-height: 1000px;
            color: #000;
            font-family: Calibri, Helvetica, sans-serif;
            font-size: 11px;
        }

        table {
            background: #fff;
        }

        span.yshortcuts {
            color: #000;
            background-color: none;
            border: none;
        }

        span.yshortcuts:hover,
        span.yshortcuts:active,
        span.yshortcuts:focus {
            color: #000;
            background-color: none;
            border: none;
        }

        a:visited {
            color: #B10035;
            text-decoration: none
        }

        a:focus {
            color: #B10035;
            text-decoration: none
        }

        a:hover {
            color: #B10035;
            font-weight: bold;
            text-decoration: none
        }

        @media only screen and (max-device-width: 480px) {


            body[yahoo] #container1 {
                display: block !important
            }

            body[yahoo] p {
                font-size: 10px
            }

        }

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {


            body[yahoo] #container1 {
                display: block !important
            }

            body[yahoo] p {
                font-size: 12px
            }

        }
    </style>
</head>

<body
        style="background:#f5f5f5; min-height:1000px; color:#000;font-family:Calibri, Arial, Helvetica, sans-serif; font-size:13px"
        alink="#B10035" link="#B10035" bgcolor="#f5f5f5" text="#FFFFFF" yahoo="fix">
<div id="body_style" style="background:#f5f5f5;padding:10px;">

    <table cellpadding="0" cellspacing="0" border="0" bgcolor="#fff" width="720" align="center">
        <tbody>
        <tr>
            <td style="padding:10px;padding-left:20px;padding-right:20px;text-align: justify;" width="700">
                <div
                        style="float:left;width:calc(100% ); font-size:16px;font-weight:bold;line-height:25px;color: #424242;text-align: justify;">

                </div>
            </td>
        </tr>
        <tr>
            <td style="padding:10px;padding-left:20px;padding-right:20px;text-align: justify;" width="700">
                <div
                        style="float:left;width:calc(100% ); font-size:14px;line-height:25px;color: #424242;text-align: justify;">
                    <div style="font-weight: bold;border-bottom: 1px solid rgb(177,0,53);">Datos enviados al Zoho
                    </div>

                    <table width="100%" style="text-align: justify;">
                        <tr>
                            <td width="5%"/>
                            <td align="left" width="90%">
                                <table width="100%" cellspacing="0" cellpadding="0">
                                    @foreach($data as $fieldName => $fieldValue)
                                        <tr>
                                            <td width="35%" style="padding:5px;padding-left:20px;border-bottom: 1px solid rgb(230,230,230)">
                                                <div
                                                        style="font-weight:bold;font-size:14px;color:rgb(177,0,53);text-align:left">
                                                    {{$fieldName}}</div>
                                            </td>
                                            <td width="65%" style="word-break:break-all;padding:5px;border-bottom: 1px solid rgb(230,230,230)">
                                                @if (is_array($fieldValue))
                                                    @foreach($fieldValue as $value)
                                                        <div style="text-align:left;font-size:14px">{!! $value ?? '' !!}</div>
                                                    @endforeach
                                                @else
                                                    <div style="text-align:left;font-size:14px">{!! $fieldValue ?? '' !!}</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                            <td width="5%"/>
                        </tr>
                    </table>
                    <br/>
                </div>
                <div
                        style="float:left;width:calc(100% ); font-size:14px;line-height:25px;color: #424242;text-align: justify;">
                    <div style="font-weight: bold;border-bottom: 1px solid rgb(177,0,53);">Error
                    </div>

                    <table width="100%" style="text-align: justify;">
                        <tr>
                            <td width="5%"/>
                            <td align="left" width="90%">
                                <div
                                        style="font-weight:bold;font-size:14px;color:rgb(177,0,53);text-align:left">
                                    {{$error}}</div>
                            </td>
                            <td width="5%"/>
                        </tr>
                        <tr>
                            <td align="left" width="100%">
                            </td>
                        </tr>
                        <tr>
                            <td width="5%"/>
                            <td align="left" width="90%">
                                <div
                                        style="font-weight:bold;font-size:14px;text-align:left">
                                    {{json_encode($data)}}</div>
                            </td>
                            <td width="5%"/>
                        </tr>
                    </table>
                    <br/>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <table cellpadding="5px" cellspacing="0" border="0" bgcolor="#fff" width="720" align="center">
        <tbody>
        <tr bgcolor="#E6E6E6" style="font-size:14px;">
            <td width="100%" align="center" style="padding:5px">
                Envío generado des de <a style=" color: #B10035 !important; text-decoration: none"
                                         href="{{Request::url()}}">{{Request::url()}}</a>
            </td>
        </tr>
        </tbody>
    </table>
    <br/>
</div>
</body>

</html>
