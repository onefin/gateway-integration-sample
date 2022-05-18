using System;
using Newtonsoft.Json.Linq;

namespace WebApplication2
{
    public partial class queryDR : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }
        protected void SubButL_Click(object sender, EventArgs e)
        {
            Request conn = new Request(virtualPaymentClientURL.Text);
            conn.AddDigitalOrderField("merchantCode", merchantCodeReq.Text);
            conn.AddDigitalOrderField("trxRefNo", trxRefNoReq.Text);
            JObject response = conn.Create3PartyQueryString();
            if (response == null) return;
            merchantCode.Text = response.GetValue("merchantCode")?.ToString();
            currency.Text = response.GetValue("currency")?.ToString();
            amount.Text = response.GetValue("amount")?.ToString();
            processingFee.Text = response.GetValue("processingFee")?.ToString();
            merchTxnRef.Text = response.GetValue("merchTxnRef")?.ToString();
            transactionId.Text = response.GetValue("transactionId")?.ToString();
            statusId.Text = response.GetValue("statusId")?.ToString();
            gatewayTransactionId.Text = response.GetValue("gatewayTransactionId")?.ToString();
            orderId.Text = response.GetValue("orderId")?.ToString();
            paymentToken.Text = response.GetValue("paymentToken")?.ToString();
            errorCode.Text = response.GetValue("errorCode")?.ToString();
            errorMessage.Text = response.GetValue("errorMessage")?.ToString();
            return;
        }
    }
}