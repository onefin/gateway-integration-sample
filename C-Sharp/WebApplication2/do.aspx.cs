using System;
using System.Collections;
using System.Configuration;
using System.ComponentModel;
using System.Data;

using System.Web;
using System.Web.Security;
using System.Web.UI;
using System.Web.UI.HtmlControls;
using System.Web.UI.WebControls;
using System.Web.UI.WebControls.WebParts;

using System.Text;
using Newtonsoft.Json.Linq;

namespace WebApplication2
{
    public partial class _Default : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if ( !IsPostBack) trxRefNo.Text = Guid.NewGuid().ToString();
        }

        protected void Button1_Click(object sender, EventArgs e)
        {
			Request conn = new Request(virtualPaymentClientURL.Text);
            // Add the Digital Order Fields for the functionality you wish to use
            // Core Transaction Fields
            conn.AddDigitalOrderField("merchantCode", merchantCode.Text);
            conn.AddDigitalOrderField("trxRefNo", trxRefNo.Text);
            conn.AddDigitalOrderField("currency", currency.Text);
            conn.AddDigitalOrderField("amount", amount.Text);
            conn.AddDigitalOrderField("backendURL", backendURL.Text);
            conn.AddDigitalOrderField("responsePageURL", responsePageURL.Text);
            conn.AddDigitalOrderField("mobileNo", mobileNo.Text);
            conn.AddDigitalOrderField("transactionMethod", transactionMethod.SelectedValue);
            conn.AddDigitalOrderField("actionMethod", actionMethod.SelectedValue);
            conn.AddDigitalOrderField("email", email.Text);
            conn.AddDigitalOrderField("addressLine1", addressLine1.Text);
            conn.AddDigitalOrderField("addressLine2", addressLine2.Text);
            conn.AddDigitalOrderField("addressLine3", addressLine3.Text);
            conn.AddDigitalOrderField("city", city.Text);
            conn.AddDigitalOrderField("postcode", postcode.Text);
            conn.AddDigitalOrderField("firstName", firstName.Text);
            conn.AddDigitalOrderField("lastName", lastName.Text);
            conn.AddDigitalOrderField("memberId", memberId.Text);
            conn.AddDigitalOrderField("paymentToken", paymentToken.Text);
            // Chuyen huong trinh duyet sang cong thanh toan
            JObject response = conn.Create3PartyQueryString();
            string url = response.GetValue("paymentURL").ToString();
            Page.Response.Redirect(url);
        }
    }
}
