using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.IO;
using Crypto;

namespace WebApplication2
{
    public partial class ipn : System.Web.UI.Page
    {
        string publicKey = "<RSAKeyValue><Modulus>k1fKrfxZ/hyPGHA5x8j7dBshtoe586uVOjuDKREIyo6yrxvpHu/ycNSXQXzBr6JLK0GKtx4+ewCHZeMhvAdqmUnvTbUjubFI+lAAOVseH1EHLzdQh3w5nUZFYYaF3INclIYKzJNqnYVhqpRdY8amfnmjVW7oFuZghG//TYGfwTS015fmQI/nLb8O8DBL9CBONupTEasD+tJ41PN15JzZ7rGMSQvMFV3QYzo0CNCk6Ya1kVAVFPso3FEDEhVURuLkPBiu1TL6jpnB/z3F2XfVfJQS43blSyJjTZ7+nSUbCu/BOEgit32gscfCYW0bQdpuvaQOW0E009+nQTd04ET8Ow==</Modulus><Exponent>AQAB</Exponent></RSAKeyValue>";
        protected void Page_Load(object sender, EventArgs e)
        {
            using (var sr = new StreamReader(Request.InputStream))
            {
                string body = sr.ReadToEnd();

                JObject jsonBody = JsonConvert.DeserializeObject<JObject>(body);

                string messages = jsonBody.GetValue("messages").ToString();
                string signature = jsonBody.GetValue("signature").ToString();
                bool isSignatureVerify = RSA.VerifyRSASHA1(messages, signature, publicKey);
                if (isSignatureVerify)
                {
                    //do somethign next
                }

            }
        }
    }
}