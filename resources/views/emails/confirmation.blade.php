<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <tr><td>Dear {{ $name }}!</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Please Click on below link to activate your account</td></tr>

        <tr><td>&nbsp;<br></td></tr>
        <tr><td><a href="{{ url('user/confirm/'.$code) }}">Confirm Account</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Mobile:-{{ $mobile }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Thanks & Regards</td></tr>
        <tr><td>&nbsp;</td></tr>

    </body>
</html>
