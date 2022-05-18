<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="do.aspx.cs" Inherits="WebApplication2._Default" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Untitled Page</title>
</head>
<body>
    <table align="center">
        <tr>
            <td>
                <table style="width: 781px; height: 59px" width="781"
                    border="2" bgcolor="#0099FF" align="center">
                    <tr>
                        <td style="width: 473px" width="473">
                            <h2 class="co">&nbsp;Virtual Payment Client
                            </h2>
                        </td>
                        <td align="center" bgcolor="#0074c4">
                            <h3 class="co">OneFin</h3>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <form id="form1" runat="server" enableviewstate="False">
                    <table width="80%" align="center">


                        <tr>
                            <td colspan="23" height="25">
                                <p><b>&nbsp;Basic 3-Party Transaction Fields</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td width="300">
                                <asp:Label ID="Label1" runat="server" Text="Vitual Payment Client"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="virtualPaymentClientURL" runat="server" ReadOnly="True" Width="250px">https://sit-pgw.onefin.vn/public/mweb/generatePayment</asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label2" runat="server" Text="MerchantCode"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="merchantCode" runat="server">00022</asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label3" runat="server" Text="Merchant Transaction Reference"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="trxRefNo" runat="server">uneque_merchTxnRef_per_txn</asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label4" runat="server" Text="Currency"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="currency" runat="server">VND</asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label5" runat="server" Text="Purchase Amount"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="amount" runat="server">1000000</asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label6" runat="server"
                                    Text="Backend ReturnURL"></asp:Label>
                            </td>
                            <td>

                                <asp:TextBox ID="backendURL" runat="server">https://sit-pgw.onefin.vn/public/mweb/mockReturnAPI</asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label7" runat="server" Text="Website Respone ReturnURL"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="responsePageURL" runat="server" Width="250px">https://example.com</asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label8" runat="server" Text="Mobile Number"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="mobileNo" runat="server">090000000</asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label9" runat="server" Text="Transaction Method"></asp:Label>
                            </td>
                            <td>

                                <asp:DropDownList ID="transactionMethod" runat="server">
                                    <asp:ListItem  Value="">null</asp:ListItem>
                                    <asp:ListItem Value="5">5 : Visa,Master,JCB</asp:ListItem>
                                    <asp:ListItem Value="10">10 : ATM (Napas)</asp:ListItem>
                                    <asp:ListItem Value="11">11 : OneFin</asp:ListItem>
                                </asp:DropDownList>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label10" runat="server" Text="Action Method"></asp:Label>
                            </td>
                            <td>
                                <asp:DropDownList ID="actionMethod" runat="server">
                                    <asp:ListItem Value="0"></asp:ListItem>
                                    <asp:ListItem Value="1"></asp:ListItem>
                                </asp:DropDownList>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label11" runat="server" Text="Merchant email"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="email" runat="server">support@onefin.vn</asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label12" runat="server" Text="Address Line 1"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="addressLine1" runat="server"></asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label13" runat="server" Text="Address Line 2"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="addressLine2" runat="server"></asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label14" runat="server" Text="Address Line 3"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="addressLine3" runat="server"></asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label15" runat="server" Text="City"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="city" runat="server"></asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label16" runat="server" Text="Post/Zip Code"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="postcode" runat="server"></asp:TextBox>
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <asp:Label ID="Label17" runat="server" Text="First Name"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="firstName" runat="server"></asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label18" runat="server" Text="Last Name"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="lastName" runat="server"></asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label19" runat="server" Text="Member ID"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="memberId" runat="server"></asp:TextBox>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <asp:Label ID="Label20" runat="server" Text="Payment Token"></asp:Label>
                            </td>
                            <td>
                                <asp:TextBox ID="paymentToken" runat="server"></asp:TextBox>
                            </td>
                        </tr>
                        <tr align="center">
                            <td colspan="2">
                                <asp:Button ID="Button1" runat="server" Text="Check out" OnClick="Button1_Click" />
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>

    </table>


</body>
</html>
