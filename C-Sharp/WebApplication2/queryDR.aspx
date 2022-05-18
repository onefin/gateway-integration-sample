<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="queryDR.aspx.cs" Inherits="WebApplication2.queryDR" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1" runat="server">
    <title>Untitled Page</title>
</head>
<body>
    <table width='100%' border='2' cellpadding='2' bgcolor='#0074C4'>
        <tr>
            <td bgcolor='#CED7EF' width='90%'>
                <h2 class='co'>&nbsp;Virtual Payment Client - Version 1</h2>
            </td>
            <td bgcolor='#0074C4' align='center'>
                <h3 class='co'>ONEFIN</h3>
            </td>
        </tr>
    </table>

    <center>
        <h2>
            <br />
            ASP.net QueryDR Example</h2>

        <form id="form1" runat="server">

            <table>

                <tr bgcolor="#CED7EF">
                    <td width="1%">&nbsp;</td>
                    <td width="40%"><b><i>Virtual Payment Client URL:&nbsp;</i></b></td>
                    <td width="55%">
                        <asp:TextBox ID="virtualPaymentClientURL" runat="server" Width="400px" Text="https://sit-pgw.onefin.vn/public/mweb/checkPayment" />
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;<hr width="75%">
                        &nbsp;</td>
                </tr>
                <tr bgcolor="#0074C4">
                    <td colspan="3" height="25">
                        <p><b>&nbsp;Basic QueryDR Transaction Fields</b></p>
                    </td>
                </tr>
                <tr bgcolor="#CED7EF">
                    <td>&nbsp;</td>
                    <td align="right"><b><i>MerchantID: </i></b></td>
                    <td>
                        <asp:TextBox ID="merchantCodeReq" runat="server" Width="200px" Text="00022"></asp:TextBox>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right"><b><i>Search Merchant Transaction Reference: </i></b></td>
                    <td>
                        <asp:TextBox ID="trxRefNoReq" runat="server" Width="200px" Text="1280954420051"></asp:TextBox>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td>
                        <asp:Button ID="SubButL" runat="server" Text="Search" OnClick="SubButL_Click" />
                    </td>
                </tr>
            </table>
            <table id="Table2" cellpadding="5" width="85%" align="center" border="0">
                <tr bgcolor="#0074c4">
                    <td colspan="2" height="25">
                        <p><strong>&nbsp;Basic Transaction Fields</strong></p>
                    </td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right" width="55%"><strong><i>Merchant Code: </i></strong>
                    </td>
                    <td width="45%">
                        <asp:Label ID="merchantCode" runat="server" Width="208px"></asp:Label>
                    </td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right" width="55%"><strong><i>Currency: </i></strong>
                    </td>
                    <td width="45%">
                        <asp:Label ID="currency" runat="server" Width="208px"></asp:Label></td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right"><strong><i>Purchase Amount: </i></strong>
                    </td>
                    <td>
                        <asp:Label ID="amount" runat="server" Width="216px"></asp:Label></td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right"><strong><i>Pocessing Fee: </i></strong>
                    </td>
                    <td>
                        <asp:Label ID="processingFee" runat="server" Width="224px"></asp:Label></td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right"><strong><i>Merchant Transaction Reference: </i></strong>
                    </td>
                    <td>
                        <asp:Label ID="merchTxnRef" runat="server" Width="200px"></asp:Label></td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right"><strong><i>Transaction ID from OneFin: </i></strong>
                    </td>
                    <td>
                        <asp:Label ID="transactionId" runat="server" Width="208px"></asp:Label></td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right"><strong><i>Transaction Response Code: </i></strong>
                    </td>
                    <td>
                        <asp:Label ID="statusId" runat="server" Width="208px"></asp:Label></td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right"><strong><i>Gateway Transaction ID: </i></strong>
                    </td>
                    <td>
                        <asp:Label ID="gatewayTransactionId" runat="server" Width="208px"></asp:Label></td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right"><strong><i>Order ID: </i></strong>
                    </td>
                    <td>
                        <asp:Label ID="orderId" runat="server" Width="208px"></asp:Label></td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right"><strong><i>Payment Token: </i></strong>
                    </td>
                    <td>
                        <asp:Label ID="paymentToken" runat="server" Width="208px"></asp:Label></td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right"><strong><i>Error Code: </i></strong>
                    </td>
                    <td>
                        <asp:Label ID="errorCode" runat="server" Width="208px"></asp:Label></td>
                </tr>
                <tr bgcolor="#ced7ef">
                    <td align="right"><strong><i>Error Message: </i></strong>
                    </td>
                    <td>
                        <asp:Label ID="errorMessage" runat="server" Width="208px"></asp:Label></td>
                </tr>
            </table>
        </form>
    </center>
</body>
</html>
