<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <title>Test cổng ONEFIN</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf8'>
    <style type="text/css">
        <!--
        h1 {
            font-family: Arial, sans-serif;
            font-size: 24pt;
            color: #08185A;
            font-weight: 100
        }

        h2.co {
            font-family: Arial, sans-serif;
            font-size: 24pt;
            color: #08185A;
            margin-top: 0.1em;
            margin-bottom: 0.1em;
            font-weight: 100
        }

        h3.co {
            font-family: Arial, sans-serif;
            font-size: 16pt;
            color: #000000;
            margin-top: 0.1em;
            margin-bottom: 0.1em;
            font-weight: 100
        }

        body {
            font-family: Verdana, Arial, sans-serif;
            font-size: 10pt;
            color: #08185A;
            background-color: #FFFFFF
        }

        a:link {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
            color: #08185A
        }

        a:visited {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
            color: #08185A
        }

        a:hover {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
            color: #FF0000
        }

        a:active {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
            color: #FF0000
        }

        .shade {
            height: 25px;
            background-color: #CED7EF
        }

        tr.title {
            height: 25px;
            background-color: #0074C4
        }

        td {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
            color: #08185A
        }

        th {
            font-family: Verdana, Arial, sans-serif;
            font-size: 10pt;
            color: #08185A;
            font-weight: bold;
            background-color: #CED7EF;
            padding-top: 0.5em;
            padding-bottom: 0.5em
        }

        .background-image {
            font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
            font-size: 12px;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
            background: url("...") 330px 59px no-repeat;
            margin: 0px;
        }

        .background-image th {
            font-weight: normal;
            font-size: 14px;
            color: #339;
            padding: 12px;
        }

        .background-image td {
            color: #669;
            border-top: 1px solid #fff;
            padding: 9px 12px;
        }

        .background-image tfoot td {
            font-size: 11px;
        }

        .background-image tbody td {
            background: url("./back.png");
        }

        * html .background-image tbody td {
            filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='table-images/back.png', sizingMethod='crop');
            background: none;
        }

        .background-image tbody tr:hover td {
            color: #339;
            background: none;
        }

        .background-image .tb_title {
            font-family: Verdana, Arial, sans-serif;
            color: #08185A;
            background-color: #CED7EF;
            font-size: 14px;
            color: #339;
            padding: 12px;
        }
        -->
    </style>
</head>

<body>
    <?php
    date_default_timezone_set('Asia/Krasnoyarsk');
    ?>
    <form action="./do.php" method="post">
        <table width="100%" align="center" border="0" cellpadding='0' cellspacing='0'>
            <tr class="shade">
                <td width="1%">&nbsp;</td>
                <td width="40%" align="right"><strong><em>URL cổng thanh toán - Virtual Payment Client
                            URL:&nbsp;</em></strong></td>
                <td width="59%"><input type="text" name="virtualPaymentClientURL" size="63" value="https://sit-pgw.onefin.vn/public/mweb/generatePayment" maxlength="250" /></td>
            </tr>
        </table>
        <center>
            <table class="background-image" summary="Meeting Results">
                <thead>
                    <tr>
                        <th scope="col" width="250px">Name</th>
                        <th scope="col" width="250px">Input</th>
                        <th scope="col" width="250px">Chú thích</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong><em>Merchant Code</em></strong></td>
                        <td><input type="text" name="merchantCode" value="00022" size="20" maxlength="16" /></td>
                        <td>Được cấp bởi OneFin</td>
                        <td>Provided by OneFin</td>
                    </tr>
                    <tr>
                        <td><strong><em>Merchant Transaction Reference</em></strong></td>
                        <td><input type="text" name="trxRefNo" value="<?php
                                                                        echo date('YmdHis') . rand();
                                                                        ?>" size="20" maxlength="50" /></td>
                        <td>ID giao dịch, giá trị phải khác nhau trong mỗi lần thanh(tối đa 50 ký tự)
                            toán
                        </td>
                        <td>ID Transaction - (unique per transaction) - (max 50 char)</td>
                    </tr>
                    <tr>
                        <td><strong><em>Currency</em></strong></td>
                        <td><input type="text" name="currency" value="VND" readonly  size="20" maxlength="34" /></td>
                        <td>Đơn vị tiền tệ (Hiện tại chỉ hỗ trợ VND)</td>
                        <td>Payment Currency (Curently support only VND)</td>
                    </tr>
                    <tr>
                        <td><strong><em>Purchase Amount</em></strong></td>
                        <td><input type="text" name="amount" value="1000000" size="20" maxlength="10" /></td>
                        <td>Số tiền cần thanh toán,Đã được nhân với 100. VD: 1000000=10000VND</td>
                        <td>Amount,Multiplied with 100, Ex: 1000000=10000VND</td>
                    </tr>
                    <tr>
                        <td><strong><em>Backend ReturnURL</em></strong></td>
                        <td><input type="text" name="backendURL" size="45" value="https://sit-pgw.onefin.vn/public/mweb/mockReturnAPI" maxlength="250" /></td>
                        <td>Url nhận kết quả trả về Merchant Server Side sau khi giao dịch hoàn thành.</td>
                        <td>Merchant Server Side URL for receiving payment result from gateway</td>
                    </tr>
                    <tr>
                        <td><strong><em>Website Respone ReturnURL</em></strong></td>
                        <td><input type="text" name="responsePageURL" size="45" value="https://example.com" maxlength="250" /></td>
                        <td>Url nhận kết quả trả về sau khi giao dịch hoàn thành.</td>
                        <td>URL for receiving payment result from gateway</td>
                    </tr>
                    <tr>
                        <td><strong><em>Mobile Number</em></strong></td>
                        <td><input type="text" name="mobileNo" value="090000000" size="20" maxlength="8" /></td>
                        <td>Số điện thoại Merchant</td>
                        <td>Merchant Mobile Number</td>
                    </tr>
                    <tr>
                        <td><strong><em>Transaction Method</em></strong></td>
                        <td>
                            <select name="transactionMethod">
                                <OPTION VALUE="">null : Select Later</OPTION>
                                <OPTION VALUE="5">5 : Visa,Master,JCB</OPTION>
                                <OPTION VALUE="10">10 : ATM (Napas)</OPTION>
                                <OPTION VALUE="11">11 : OneFin</OPTION>
                            </select>
                        </td>
                        <td>Phương thức thanh toán (null : lựa chọn phương thức thanh toán bên OneFin, 5: Visa, Master, JCB, 10: ATM (Napas), , 11: Ví OneFin)</td>
                        <td>Payment Method (null : select payment method from OneFin Gateway, 5: Visa, Master, JCB, 10: ATM (Napas), , 11: OneFin Wallet)</td>
                    </tr>
                    <tr>
                        <td><strong><em>Action Method</em></strong></td>
                        <td>
                            <select name="actionMethod">
                                <OPTION VALUE="0">0</OPTION>
                            </select>
                        </td>
                        <td>Hiện chỉ hỗ trợ actionMethod = 0</td>
                        <td>Curently suupport actionMethod = 0</td>
                    </tr>
                    <tr>
                        <td><strong><em>Merchant email</em></strong></td>
                        <td><input type="text" name="email" size="20" value="support@onefin.vn" maxlength="50" /></td>
                        <td>Địa chỉ hòm thư của merchant (chỉ bắt buộc khi phương thức thanh toán là Credit / Debit Card (CYBS) – transactionMethod = 5 hoặc chọn phương thức thanh toán bên OneFin Gateway - transactionMethod = null) </td>
                        <td>Merchant email (mandatory only for "Credit / Debit Card (CYBS) – transactionMethod = 5 or select payment method on OneFin Gateway - transactionMethod = null").</td>
                    </tr>
                </tbody>
            </table>
            <table class="background-image" summary="Meeting Results">
                <thead>
                    <tr>
                        <th scope="col" colspan="4">Billing Address</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td align="center" colspan="4"><input type="submit" value="Pay Now!" /></td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td scope="col" width="250px"><strong><em>Address Line 1</em></strong></td>
                        <td scope="col" width="250px"><input type="text" name="addressLine1" size="45" maxlength="255" /></td>
                        <td scope="col" width="250px">Địa chỉ người dùng 1</td>
                        <td scope="col">User address line 1</td>
                    </tr>
                    <tr>
                        <td><strong><em>Address Line 2</em></strong></td>
                        <td><input type="text" name="addressLine2" size="45" maxlength="255" /></td>
                        <td>Địa chỉ người dùng 2</td>
                        <td>User address line 2</td>
                    </tr>
                    <tr>
                        <td><strong><em>Address Line 3</em></strong></td>
                        <td><input type="text" name="addressLine3" size="45" maxlength="255" /></td>
                        <td>Địa chỉ người dùng 3</td>
                        <td>User address line 3</td>
                    </tr>
                    <tr>
                        <td><strong><em>City</em></strong></td>
                        <td><input type="text" name="city" maxlength="255" size="45" value="" /></td>
                        <td>Thành phố của người dùng</td>
                        <td>User city of residence</td>
                    </tr>
                    <tr>
                        <td><strong><em>Post/Zip Code</em></strong></td>
                        <td><input type="text" name="postcode" maxlength="5" value="" /></td>
                        <td>Mã vùng của người dùng</td>
                        <td>User postal code</td>
                    </tr>
                    <tr>
                        <td><strong><em>First Name</em></strong></td>
                        <td><input type="text" name="firstName" maxlength="255" value="" /></td>
                        <td>Tên người dùng</td>
                        <td>User First Name</td>
                    </tr>
                    <tr>
                        <td><strong><em>Last Name</em></strong></td>
                        <td><input type="text" name="lastName" maxlength="255" value="" /></td>
                        <td>Họ người dùng</td>
                        <td>User Last Name</td>
                    </tr>
                    <tr>
                        <td><strong><em>Member ID</em></strong></td>
                        <td><input type="text" name="memberId" readonly  maxlength="255" value="" /></td>
                        <td>ID thành viên của người dùng (hiện không khả dụng )</td>
                        <td>Member ID (curently unavailable)</td>
                    </tr>
                    <tr>
                        <td><strong><em>Payment Token</em></strong></td>
                        <td><input type="text" name="paymentToken" maxlength="255" readonly value="" /></td>
                        <td>Token thanh toán (hiện không khả dụng )</td>
                        <td>Payment Token (curently unavailable)</td>
                    </tr>
                </tbody>
            </table>
        </center>
    </form>
</body>

</html>